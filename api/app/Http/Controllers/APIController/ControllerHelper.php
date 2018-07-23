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
use Illuminate\Support\Facades\Schema;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\CompanyBranchEmployee;

use App\Http\Controllers\Controller;

class ControllerHelper extends Controller
{
  protected $validation;
  protected $response = array(
    "data" => null,
    "error" => array(),// {status, message}
    "debug" => null,
    "response_type" => 'json',
    "request_timestamp" => 0
  );
  protected $rawRequest = null;
  protected $model = null;
  function __construct($response, $validation){
    $this->response = $response;
    $this->validation = $validation;
  }
  public function filterRequest($request){
    foreach($this->tableColumns as $column){
      switch($column){
        case "company_id":
          if($this->useUserCompanyID){
            $request[$column] = $this->getUserCompanyID();
          }
          break;
      }
    }
    return $request;
  }
  public function isValid($request, $action = "create", $subTableName = false){
    /*Require all fields*/
    unset($this->tableColumns[0]);
    array_pop($this->tableColumns);//deleted at
    array_pop($this->tableColumns);//updated at
    array_pop($this->tableColumns);//created at
    foreach($this->tableColumns as $column){
      $this->validation[$column] = (isset($this->validation[$column])) ? $this->validation[$column] : '';
      if(!in_array($column, $this->notRequired) && !isset($this->defaultValue[$column])){//requiring all field by default
        if($action !== "update"){
          $this->validation[$column] = $this->validation[$column].($this->validation[$column] ? "| ":"")."required";
        }else if($action === "update"){
          if(in_array($column, $request)){
            $this->validation[$column] = $this->validation[$column].($this->validation[$column] ? "| ":"")."required";
          }else{

            unset($this->validation[$column]);
          }
        }
      }
    }
    if($action == "update"){
      $this->validation["id"] = "required";
      if(!isset($request["id"])){
        $this->response["error"]["status"] = 102;
        $this->response["error"]["message"] = "ID required";
        return false;
      }
    }
    if(count($this->validation)){
      foreach($this->validation as $validationKey => $validationValue){
        if($action == "update"){
          if(strpos( $validationValue, "unique" ) !== false ) { //check if rule has unique
            $rules = explode("|", $this->validation[$validationKey]);
            foreach($rules as $ruleKey => $ruleValue){ //find the unique rule
              if(strpos( $ruleValue, "unique" ) !== false){
                $rules[$ruleKey] = Rule::unique(str_replace("unique:", "", $ruleValue), $validationKey)->ignore($request["id"], "id");
              }
            }
            $this->validation[$validationKey] = $rules;
          }
        }
        if(strpos( $validationKey, "_id" ) !== false && (isset($request[$validationKey]) && $request[$validationKey] !== null)){ // 2nd condition: make nullable not requred
          $table = explode(".", str_plural(str_replace("_id", "", $validationKey)));
          $table = (count($table) > 1) ? $table[1] : $table[0];
          if(strpos( $validationKey, "parent" ) !== false){
            $table = $this->model->getTable();
          }
          if(Schema::hasTable($table)){
            $this->validation[$validationKey] = $this->validation[$validationKey]."|exists:".$table.",id";
          }
        }
      }
      $validator = Validator::make($request, $this->validation);
      if ($validator->fails()) {
        if(!$subTableName){
          $this->response["error"][] = array(
            'status' => 100,
            'message' => $validator->errors()->toArray()
          );
        }
        return false;
      }else{
        return true;
      }
    }
  }
  public function output($response = NULL){
    $response = $response ? $response : $this->response;
    // sleep(2); // emulate delay
    $response["request_timestamp"] = date("Y-m-d h:i:s");
    if($response['response_type'] == 'array'){
      return $response;
    }else{
      return response()->json($response);
    }
  }
  public function uploadSingleImageFile($id, $inputName, $path, $dbColumn, $replace = false){
    if($id){
      // $this->printR($this->rawRequest);
      if ($this->rawRequest->hasFile($inputName) && $this->rawRequest->file($inputName)->isValid()){
        /***
          The file being sent is saved in app
        **/
        $imagePath = $this->rawRequest[$inputName]->store($path);
        // echo "imagepath: $imagePath, path: $path  ||";
        if($replace){
          $modelTemp = clone $this->model;
          $entry = $this->model->where('id', $id)->get()->toArray();
          if(count($entry) && $entry[0][$dbColumn] != '' && $entry[0][$dbColumn] != null){
            Storage::delete($path.'/'.$entry[0][$dbColumn]);
          }
          $this->model = $modelTemp;
        }
        // $responseTemp = $this->response;
        $modelTemp = (new $this->model)->find($id);
        $modelTemp->$dbColumn = str_replace($path.'/', '', $imagePath);
        $modelTemp->save();
        // echo 'idddd'.$id;
        // $this->printR($modelTemp->find($id)->get()->toArray());
        // $modelTemp->updateEntry(array(
        //   'id' => $id,
        //   $dbColumn => str_replace($path.'/', '', $imagePath)
        // ), true);
        // $this->response = $responseTemp;
        return true;
      }else{
        echo 'shit no file';
      }
    }
    return false;
  }
  public function printR($object){
    echo "<pre>";
    print_r($object);
    echo "</pre>";
  }
  public function getAuthenticatedUser(){
    try {
      if (! $userRaw = JWTAuth::parseToken()->authenticate()) {
        return response()->json(['user_not_found'], 404);
      }
    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
      return response()->json(['token_expired'], $e->getStatusCode());
    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
      return response()->json(['token_invalid'], $e->getStatusCode());
    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
      return response()->json(['token_absent'], $e->getStatusCode());
    } catch(\Tymon\JWTAuth\Exceptions\JWTException $e){//general JWT exception
      return false;
    }
    // the token is valid and we have found the user via the sub claim
    $user = $userRaw->toArray();
    $this->userSession = $user;
    $this->userSession['company_id'] = NULL;
    $this->userSession['company_branch_id'] = NULL;
  }
  public function getUserCompanyID(){
    $this->getUserCompanyDetail();
    return $this->userSession['company_id'];
  }
  public function getUserCompanyBranchID(){
    $this->getUserCompanyDetail();
    return $this->userSession['company_branch_id'];
  }
  public function getUserID(){
    if(!$this->userSession){
      $this->getAuthenticatedUser();
    }
    return $this->userSession['id'];
  }
  public function getUserAccountType(){
    if(!$this->userSession){
      $this->getAuthenticatedUser();
    }
    return $this->userSession['account_type_id'] * 1;
  }


}