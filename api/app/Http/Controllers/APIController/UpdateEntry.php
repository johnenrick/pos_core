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
use App\CompanyBranchEmployee;

use App\Http\Controllers\Controller;

class UpdateEntry extends ControllerHelper
{
  protected $response = null;
  protected $responseType = null;
  protected $controllerHelper;
  protected $tableColumns = null;
  protected $model = null;
  protected $notRequired = null;
  protected $singleImageFileUpload = array();
  protected $editableForeignTable = array();



  function __construct($model, $response, $validation, $tableColumns, $notRequired, $editableForeignTable, $rawRequest){
    $this->response = $response;
    $this->responseType = $response['response_type'];
    $this->tableColumns = $tableColumns;
    $this->model = $model;
    $this->notRequired = $notRequired;
    $this->editableForeignTable = $editableForeignTable;
    $this->validation = $validation;
    $this->rawRequest = $rawRequest;
  }

  public function updateEntry($request){
    $tableColumns = $this->model->getTableColumns();
    $this->tableColumns = $tableColumns;
    $request = $this->filterRequest($request);
    $tableColumns = $this->model->getTableColumns();

    $this->tableColumns = $tableColumns;
    if(!$this->isValid($request, "update")){
      return $this->output();
    }
    $this->model = $this->model->find($request["id"]);
    foreach($this->tableColumns as $columnName){
      if(isset($request[$columnName])){
        $this->model->$columnName = $request[$columnName];//setting attribute
      }else if(isset($this->defaultValue[$columnName]) && isset($request[$columnName])){
        $this->model->$columnName = $this->defaultValue[$columnName];
      }

    }
    $result = $this->model->save();
    if($result && count($this->singleImageFileUpload) && !$noFile){
      $id = $this->model->id;
      for($x = 0; $x < count($this->singleImageFileUpload); $x++){
        $this->uploadSingleImageFile(
          $id,
          $this->singleImageFileUpload[$x]['name'],
          $this->singleImageFileUpload[$x]['path'],
          $this->singleImageFileUpload[$x]['column'],
          $this->singleImageFileUpload[$x]['replace']
        );
      }
    }
    if($result && $this->editableForeignTable){

      $childID = array();
      foreach($this->editableForeignTable as $childTable => $childTableValue){

        if(is_string($childTableValue)){
          $childTable = $childTableValue;
        }
        if(isset($request[$childTable]) && $request[$childTable]){
          $child = $request[$childTable];
          if(count(array_filter(array_keys($child), 'is_string')) > 0){//associative
            $this->response['debug'][] = 'test1';
            if(!isset($childID[$childTable])){
              $childID[$childTable] = array();
            }
            $this->response['debug'][] = $child["id"];
            $result = false;
            if(isset($child["id"]) && $child["id"]*1) { // update
              $this->response['debug'][] = 'test2';
              $pk = $child["id"];
              unset($child["id"]);
              $result = $this->model->find($this->model->id)->$childTable()->where('id', $pk)->where(str_singular($this->model->getTable()).'_id', $request["id"])->update($child);
            }else if(!isset($childTableValue['no_create_on_update'])){
              $result = $this->model->find($this->model->id)->$childTable()->create($child)->id;
            }
            $childID[$childTable] = $result;
          }else{ // list
            foreach($child as $childValue){
              if(!isset($childID[$childTable])){
                $childID[$childTable] = array();
              }
              $result = false;
              if(isset($childValue["id"]) && $childValue["id"]*1) {//update
                $pk = $childValue["id"];
                unset($childValue["id"]);
                $foreignTable = $this->model->find($this->model->id)->$childTable()
                  ->where('id', $pk)
                  ->where(str_singular($this->model->getTable()).'_id', $request["id"]);
                foreach($childValue as $childValueKey => $childValueValue){
                  if($childValueValue == null || $childValueValue == ""){
                    $foreignTable->$childValueKey = $childValueValue;
                  }
                }
                $result = $foreignTable
                  ->update($childValue);
                // $foreignTable->save($foreignTable);

              }else{ //create
                $childValue[str_singular($this->model->getTable()).'_id'] = $this->model->id;
                $foreignTable = $this->model->newModel($childTable, $childValue);
                // foreach($childValue as $childValueKey => $childValueValue){
                //   if($childValueValue == null || $childValueValue == ""){
                //     $foreignTable->$childValueKey = $childValueValue;
                //   }
                // }
                $result = $this->model->find($this->model->id)->$childTable()->save($foreignTable)->id;
              }
              $childID[$childTable][] = $result;
            }
          }
        }
        if(isset($request['deleted_foreign_table'][$childTable])){
          for($x = 0; $x < count($request['deleted_foreign_table'][$childTable]); $x++){
            $this->model->find($this->model->id)->$childTable()->where('id', $request['deleted_foreign_table'][$childTable][$x])->delete();
          }
        }
      }

      $response = $this->model->id;
      if(count($childID)){
        $childID["id"] = $response;
        $response = $childID;
      }
      $this->response["data"] = $response;
    }else{
      if($result){
        $this->response["data"] = $result;
      }else{
        $this->response["error"] = "Failed to update entry";
      }
    }
    return $this->response;
  }
}