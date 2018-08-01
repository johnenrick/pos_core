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

class CreateEntry extends ControllerHelper
{
  protected $test = 'hello';
  // protected $response = null;
  protected $responseType = null;
  protected $controllerHelper;
  protected $tableColumns = null;
  protected $notRequired = null;
  protected $singleImageFileUpload = array();
  protected $editableForeignTable = array();
  protected $defaultValue = array();
  function __construct($model, $response, $validation, $tableColumns, $notRequired, $editableForeignTable, $singleImageFileUpload, $rawRequest, $defaultValue){
    $this->response = $response;
    $this->responseType = isset($response['response_type']) ? $response['response_type'] : 'json';
    $this->tableColumns = $tableColumns;
    $this->model = $model;
    $this->notRequired = $notRequired;
    $this->editableForeignTable = $editableForeignTable;
    $this->validation = $validation;
    $this->singleImageFileUpload = $singleImageFileUpload;
    $this->rawRequest = $rawRequest;
    $this->defaultValue = $defaultValue;
  }

  public function createEntry($request){
    $model = clone $this->model;
    $tableColumns = $this->tableColumns;
    $request = $this->filterRequest($request);

    if(!$this->isValid($request, "create")){
      return $this->response;
    }
    unset($tableColumns[0]);
    foreach($tableColumns as $columnName){
      if(isset($request[$columnName])){
        $model->$columnName = $request[$columnName];
      }else if(isset($this->defaultValue[$columnName])){
        $model->$columnName = $this->defaultValue[$columnName];
      }
    }
    $model->save();
    $childID = array();
    if($model->id && count($this->singleImageFileUpload)){
      for($x = 0; $x < count($this->singleImageFileUpload); $x++){
        $this->uploadSingleImageFile(
          $model->id,
          $this->singleImageFileUpload[$x]['name'],
          $this->singleImageFileUpload[$x]['path'],
          $this->singleImageFileUpload[$x]['column']
        );
      }
    }
    if($model->id && $this->editableForeignTable){
      foreach($this->editableForeignTable as $childTable){
        if(isset($request[$childTable]) && $request[$childTable]){
          $child = $request[$childTable];
          if(count(array_filter(array_keys($child), 'is_string')) > 0){//associative
            if(!isset($childID[$childTable])){
              $childID[$childTable] = array();
            }
            $child[str_singular($model->getTable()).'_id'] = $model->id;
            $foreignTable = $model->newModel($childTable, $child);
            foreach($child as $childKey => $childValue){
              $foreignTable->$childKey = $childValue;
            }
            $result = $model->find($model->id)->$childTable()->save($foreignTable);
            $childID[$childTable][] = $result["id"];
          }else{ // list
            foreach($child as $childValue){
              if(!isset($childID[$childTable])){
                $childID[$childTable] = array();
              }
              $childValue[str_singular($model->getTable()).'_id'] = $model->id;
              $foreignTable = $model->newModel($childTable, $childValue);
              foreach($childValue as $childValueKey => $childValueValue){
                if($childValueValue == null || $childValueValue == "" || empty($childValueValue)){
                  $foreignTable->$childValueKey = $childValueValue;
                }
              }
              $result = $model->find($model->id)->$childTable()->save($foreignTable);
              $childID[$childTable][] = $result["id"];
            }
          }
        }
      }
      $response = $model->id;
      if(count($childID)){
        $childID["id"] = $model->id;;
        $response = $childID;
      }
      $this->response["data"] = $response;
    }else{
      if($model->id){
        $this->response["data"] = $model->id;
      }else{
        $this->response["error"]["status"] = 1;
        $this->response["error"]["message"] = "Failed to create entry in database";
      }
    }
    return $this->response;
  }
}