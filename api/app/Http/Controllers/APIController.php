<?php

namespace App\Http\Controllers;

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

use App\Http\Controllers\APIController\CreateEntry;
use App\Http\Controllers\APIController\RetrieveEntry;
use App\Http\Controllers\APIController\UpdateEntry;
use App\Http\Controllers\APIController\DeleteEntry;
use App\Http\Controllers\APIController\ControllerHelper;

class APIController extends ControllerHelper
{
    protected $model = null;
    protected $validation = array();
    protected $test = null;
    protected $userSession = null;
    protected $response = array(
      "data" => null,
      "error" => array(),// {status, message}
      "debug" => null,
      "response_type" => 'json',
      "request_timestamp" => 0
    );
    protected $responseType = 'json';
    protected $rawRequest = null;

    protected $notRequired = array();
    protected $defaultValue = array();
    protected $requiredForeignTable = array();//children that are always retrieve, singular
    /***
      Array of columns that are aliased for derived/computed. The key is the alias and the value is the actual or formula of the column
      e,g.
      {
        total_total_quantity: SUM(quantity),
        full_name: concat(first_name, ' ', last_name)
      }
    **/
    protected $aliased = array();
    /**
      Array for single fileupload input.
      [{
        "name" => '', Name of the input
        "path" => '', Path to be saved
        "column" => '', column name in the table
        "replace" => Boolean Delete previous file
      }]
    **/
    protected $singleImageFileUpload = array();
    /***
      Array of editable table. The value can be list of table names or associative array of table with its rules
      List:
        [table1, table2, table3]
      With rules
        [
          table1 => array(
            no_create_on_update: true
          )
          table2 => array()
        ]
      Rules:
        no_create_on_update boolean prevent creation of foreign table during update operation
    **/
    protected $editableForeignTable = array();
    protected $foreignTable = array();
    protected $useUserCompanyID = true;
    /*Hooks*/
    /*Controller Global*/
    protected $tableColumns = null;
    protected $tableName = null;

    public function test(){
      $user = $this->getUserCompanyID();
      // $this->printR($this->userSession);
      // echo response()->json($user);
    }
    public function APIControllerConstructor(){
      $this->tableColumns = $this->model->getTableColumns();
      $this->tableName = $this->model->getTable();
      $response['response_type'] = isset($request['response_type']) ? $request['response_type'] : 'json';
    }

    public function create(Request $request){
      $this->rawRequest = $request;
      return $this->createEntry($request->all());
    }
    public function retrieve(Request $request){
      $this->rawRequest = $request;
      return $this->retrieveEntry($request->all());
    }
    public function update(Request $request){
      $this->rawRequest = $request;
      if ($request->hasFile('image_file')){
      }
      else{
      }

      return $this->updateEntry($request->all());
    }
    public function delete(Request $request){
      return $this->deleteEntry($request->all());
    }

    public function createEntry($request){
      $createModule = new CreateEntry(
        $this->model,
        $this->response,
        $this->validation,
        $this->tableColumns,
        $this->notRequired,
        $this->editableForeignTable
      );
      return $createModule->createEntry($request);
    }
    public function retrieveEntry($request){
      $retrieveModule = new RetrieveEntry(
        $this->model,
        $this->response,
        $this->tableName,
        $this->tableColumns,
        $this->validation,
        $this->foreignTable,
        $this->editableForeignTable,
        $this->requiredForeignTable,
        $this->aliased
      );
      $this->response['debug'][] = 'test';
      return $retrieveModule->retrieveEntry($request);
    }
    public function updateEntry($request, $noFile = false){
      $updateModule = new UpdateEntry(
        $this->model,
        $this->response,
        $this->validation,
        $this->tableColumns,
        $this->notRequired,
        $this->editableForeignTable
      );
      return $updateModule->updateEntry($request);
    }
    public function deleteEntry($request){
      $deleteEntry = new DeleteEntry($this->model, $this->response);
      return $deleteEntry->deleteEntry($request);
    }


}
