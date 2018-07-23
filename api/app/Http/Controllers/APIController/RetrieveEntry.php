<?php

namespace App\Http\Controllers\APIController;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\CompanyBranchEmployee;

use App\Http\Controllers\Controller;

class RetrieveEntry extends ControllerHelper
{
  protected $response = null;
  protected $responseType = null;
  protected $controllerHelper;
  protected $foreignTable = null;
  protected $editableForeignTable = null;
  protected $requiredForeignTable = null;
  protected $tableName = null;
  protected $tableColumns = null;
  protected $model = null;
  protected $aliased = null;
  protected $groupByColumn = null;
  protected $select = null;
  protected $leftJoinChildTable = null;
  function __construct($model, $response, $tableName, $tableColumns, $validation, $foreignTable, $editableForeignTable, $requiredForeignTable, $aliased, $groupByColumn, $select, $leftJoinChildTable){
    $this->response = $response;
    $this->foreignTable = $foreignTable;
    $this->editableForeignTable = $editableForeignTable;
    $this->requiredForeignTable = $requiredForeignTable;
    $this->tableName = $tableName;
    $this->tableColumns = $tableColumns;
    $this->model = $model;
    $this->aliased = $aliased;
    $this->groupByColumn = $groupByColumn;
    $this->select = $select;
    $this->leftJoinChildTable = $leftJoinChildTable;
  }
  public function retrieveEntry($request){
    $allowedForeignTable = array_merge($this->foreignTable, $this->editableForeignTable, $this->requiredForeignTable);
    $tableName = $this->tableName;
    $singularTableName = str_singular($tableName);
    $tableColumns = $this->tableColumns;
    // if(count($this->requiredForeignTable)){
    //   for($x = 0; $x < count($this->requiredForeignTable); $x++){
    //     $singularForeignTable = str_singular($this->requiredForeignTable[$x]);
    //     $pluralForeignTable = str_plural($this->requiredForeignTable[$x]);
    //     $this->response['debug']['join'] = $pluralForeignTable;
    //     $this->model = $this->model->leftJoinChildTable($pluralForeignTable, $pluralForeignTable.'.id', '=', $tableName.'.'.$singularForeignTable.'_id');
    //   }
    // }
    if(isset($request['sort'])){
      foreach($request['sort'] as $sortKey => $sortValue){
        $sortKeySegment = explode('.', $sortKey);
        // print_r($this->leftJoinChildTable);
        // print_r($sortKeySegment);
        // print_r($allowedForeignTable);
        // print_r($this->foreignTable);
        // echo 'tae';
        if(count($sortKeySegment) == 2){
          $table = str_plural($sortKeySegment[0]);
          unset($request['sort'][$sortKey]);
          $request['sort'][$table.'.'.$sortKeySegment[1]] = $sortValue;

          if(in_array($sortKeySegment[0], $allowedForeignTable) && ($this->leftJoinChildTable == null || isset($this->leftJoinChildTable[$sortKeySegment[0]]))){
            $singularForeignTable = str_singular($table);
            if(in_array($singularForeignTable.'_id', $tableColumns)){ // the table is child
              $this->model = $this->model->leftJoin($table, $table.'.id', '=', $tableName.'.'.$singularForeignTable.'_id');
            }else{ // the table is parent
              $this->model = $this->model->leftJoin($table, $tableName.'.id', '=', $table.'.'.$singularTableName.'_id');
            }
          }

        }
      }
    }
    if($this->leftJoinChildTable){
      foreach($this->leftJoinChildTable as $table => $queryOption){
        $singularForeignTable = str_singular($table);
        $this->model = $this->model->leftJoin($table, $tableName.'.id', '=', $table.'.'.$singularTableName.'_id');
      }
    }
    $condition = isset($request['condition']) ? $this->initCondition($request['condition']) : array('main_table' => array(), 'foreign_table' => array());
    if(isset($request['with_foreign_table'])){
      foreach($request['with_foreign_table'] as $foreignTable){
        if(in_array($foreignTable, $allowedForeignTable)){
          $this->model = $this->model->with($request['with_foreign_table']);
        }
      }
    }
    if(!empty($condition['foreign_table'])){
      $foreignTable = array();
      if($this->groupByColumn){
        foreach($condition['foreign_table'] as $foreignTable => $foreignCondition){
          for($x = 0; $x < count($foreignCondition); $x++){
            $column = explode('.', $foreignCondition[$x]['column']);
            $clause = isset($foreignCondition[$x]['clause']) ? $foreignCondition[$x]['clause'] : '=';
            $value = $foreignCondition[$x]['value'];
            if(count($column) <= 2){ // level 1 relation
              $this->model = $this->model->where(str_plural($foreignTable).'.'.$column[1], $clause, $value);
            }else{ // level 2 relation. maybe more
              $column2 = $column[2];
              $q->whereHas($column[1], function($q2) use($column2, $clause, $value){
                $q2->where($column2, $clause, $value);
              });
            }
          }
        }
      }else{
        // TODO revise this to a recursive function
        foreach($condition['foreign_table'] as $foreignTable => $foreignCondition){
          $this->model = $this->model->whereHas($foreignTable, function($q) use($foreignCondition, $foreignTable){
            $tempForeignTablePlural = str_plural($foreignTable);
            for($x = 0; $x < count($foreignCondition); $x++){ // loop each
              $column = explode('.', $foreignCondition[$x]['column']);
              $value = $foreignCondition[$x]['value'];
              $clause = isset($foreignCondition[$x]['clause']) ? $foreignCondition[$x]['clause'] : '=';
              if(count($column) <= 2){ // level 1 relation
                $q->where($column[1], $clause, $value);
              }else{ // level 2 relation. maybe more
                $column2 = $column[2];
                $q->whereHas($column[1], function($q2) use($column2, $clause, $value){
                  $q2->where($column2, $clause, $value);
                });
              }
            }
          });
        }
      }
    }

    if(count($this->requiredForeignTable)){
        $this->model = $this->model->with($this->requiredForeignTable);
    }
    if($this->aliased){
      foreach($this->aliased as $column => $formula){
        $this->model = $this->model->addSelect(DB::raw("$formula as $column"));
      }
    }
    if(count($condition['main_table'])){

      $this->addCondition($condition['main_table']);
    }

    if(isset($request["id"])){
       $this->model = $this->model->where($tableName.".id", "=", $request["id"]);
    }else{
      isset($request['sort']) ? $this->sort( $request['sort']) : null;
      if(isset($request['limit'])){
        $this->response['total_entries'] = $this->model->count();
        if(isset($request['calculated_column'])){
          $this->response['calculated_column'] = array();
          foreach($request['calculated_column'] as $alias => $formula){
            $tempModel = clone $this->model;
            // $tempModel = $tempModel->groupBy($tableName.'.id');
            $tempModel = $tempModel->addSelect(DB::raw("$formula as $alias"));
            $tempResult = $tempModel->get([$alias])->toArray();
            $this->response['calculated_column'][$alias] = count($tempResult) ? $tempResult[0][$alias] : NULL;
          }
        }
        $this->model = $this->model->limit($request['limit']);
      }
      (isset($request['offset'])) ?  $this->model = $this->model->offset($request['offset'] * 1) : null;

    }
    if($this->groupByColumn){
      foreach($this->groupByColumn as $value)
      $this->model = $this->model->groupBy(DB::raw($value));
    }
    if($this->select){
      $this->model = $this->model->addSelect($this->select);
    }

    if(isset($request['with_soft_delete'])){
      $this->model = $this->model->withTrashed();
    }

    for($x = 0; $x < count($tableColumns); $x++){
      $tableColumns[$x] = $tableName.'.'.$tableColumns[$x];
    }
    $result = $this->model->get($tableColumns)->toArray();
    if(count($result)){

      if(isset($request["id"])){
        $this->response["data"] = $result[0];
      }else{
        $this->response["data"] = $result;
      }
    }else{
      $this->response["error"][] = [
        "status" => 200,
        "message" => "No Result"
      ];
    }
    return $this->response;
  }
  function initCondition($condition){
    $initializedCondition = array(
      "main_table" => array(),
      "foreign_table" => array()
    );
    if(isset($condition)){
      for($x = 0; $x < count($condition); $x++){
        $columnExploded = explode('.', $condition[$x]['column']);
        if(count($columnExploded) > 1){ // foreign table
          if(!isset($initializedCondition['foreign_table'][$columnExploded[0]])){
            $initializedCondition['foreign_table'][$columnExploded[0]] = array();
          }
          $initializedCondition['foreign_table'][$columnExploded[0]][] = $condition[$x];
        }else{
          if($this->aliased && isset($this->aliased[$condition[$x]['column']])){
            $condition[$x]['column'] = DB::raw($this->aliased[$condition[$x]['column']]);
          }else{
            $condition[$x]['column'] = $this->tableName.'.'.$condition[$x]['column'];
          }

          $initializedCondition['main_table'][] = $condition[$x];
        }

      }
    }
    return $initializedCondition;
  }
  public function addCondition($conditions){
    /*
      column, clause, value
    */
    if($conditions){
      foreach($conditions as $condition){
        /*Table.Column, Clause, Value*/
        $condition["clause"] = (isset($condition["clause"])) ? $condition["clause"] : "=";
        if(!isset($condition["value"]) || $condition["value"] == 'NULL'){
          $condition["value"] = null;
        }
        switch($condition["clause"]){
          default :
            $this->response['debug'][] = $condition;
            $this->model = $this->model->where($condition["column"], $condition["clause"], $condition["value"]);
        }
      }
    }
  }
  /***
    Convert the column to sort into its real column name or formula since the laravel eloquent cannot sort aliases
    Return transformed sortObject
  **/
  function sort($sortObject){
    foreach($sortObject as $sortColumn => $sortValue){
      $columName = $sortColumn;
      if(isset($this->aliased[$sortColumn])){
        $columName = $this->aliased[$sortColumn];
      }
      $this->model = $this->model->orderBy(DB::raw($columName), $sortValue);
    }
  }
}