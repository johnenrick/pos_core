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
    protected $responseType = 'json';
    // protected $rawRequest = null;

    protected $notRequired = array();
    protected $defaultValue = array();
    protected $requiredForeignTable = array();//children that are always retrieve, singular
    protected $rawRequest = null;
    /***
      Array of aliased table
      e.g. [
        table_alias: {
          condition
        }
      ]
    **/
    protected $aliasedTable = [
    ];
    /***
      Array of columns that are aliased for derived/computed. The key is the alias and the value is the actual or formula of the column
      e,g.
      {
        total_total_quantity: SUM(quantity),
        full_name: concat(first_name, ' ', last_name)
      }
    **/
    protected $aliased = array();
    protected $leftJoinChildTable = null;
    protected $rightJoinChildTable = null;
    protected $groupByColumn = array();
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
    /***
      Replace the data with the data from session such as user id or company id
      The key is the field name and the value is the session data: user_id, user_company_id
    **/
    protected $replaceSessionData = array();
    protected $select = null;
    /*Controller Global*/
    protected $tableColumns = null;
    protected $tableName = null;
    protected $ownerColumn = null;
    public function test(){
      $user = $this->getUserCompanyID();
      // $this->printR($this->userSession);
      // echo response()->json($user);
    }
    public function replaceSessionData($request){
      foreach($this->replaceSessionData as $key => $value){
        switch($value){
          case 'user_id':
            $request[$key] = $this->getUserID();
            break;
          case 'user_company_id':
            $request[$key] = $this->getUserCompanyID();
            break;
        }
      }
      return $request;
    }
    public function APIControllerConstructor(){
      $this->getAuthenticatedUser();
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
      $requestArray = $request->all();
      return $this->retrieveEntry($requestArray);
    }
    public function update(Request $request){
      $this->rawRequest = $request;
      if ($request->hasFile('image_file')){
      }
      return $this->updateEntry($request->all());
    }
    public function delete(Request $request){
      if($this->ownerColumn){
        $this->rawRequest[$this->ownerColumn] = $this->getUserID();
      }
      return $this->deleteEntry($request->all());
    }

    public function createEntry($request){
      $this->APIControllerConstructor();
      if($this->ownerColumn){
        $request[$this->ownerColumn] = $this->getUserID();
      }
      $createModule = new CreateEntry(
        $this->model,
        $this->response,
        $this->validation,
        $this->tableColumns,
        $this->notRequired,
        $this->editableForeignTable,
        $this->singleImageFileUpload,
        $this->rawRequest,
        $this->defaultValue
      );
      return $createModule->createEntry($this->replaceSessionData($request));
    }
    public function retrieveEntry($request){
      $this->APIControllerConstructor();
      !isset($request['condition']) ? $request['condition'] = array() : NULL;
      if($this->ownerColumn){
        $request['condition'][] = array(
          'column' => $this->ownerColumn,
          'value' => $this->getUserID()
        );
      }
      $retrieveModule = new RetrieveEntry(
        $this->model,
        $this->response,
        $this->tableName,
        $this->tableColumns,
        $this->validation,
        $this->foreignTable,
        $this->editableForeignTable,
        $this->requiredForeignTable,
        $this->aliased,
        $this->groupByColumn,
        $this->select,
        $this->leftJoinChildTable,
        $this->rightJoinChildTable
      );
      return $retrieveModule->retrieveEntry($request);
    }
    public function updateEntry($request, $noFile = true){
      if($this->ownerColumn){
        $request[$this->ownerColumn] = $this->getUserID();
      }
      $this->APIControllerConstructor();
      $updateModule = new UpdateEntry(
        $this->model,
        $this->response,
        $this->validation,
        $this->tableColumns,
        $this->notRequired,
        $this->editableForeignTable,
        $this->singleImageFileUpload,
        $this->rawRequest
      );
      return $updateModule->updateEntry($this->replaceSessionData($request));
    }
    public function deleteEntry($request){
      $this->APIControllerConstructor();
      if($this->ownerColumn){
        $request[$this->ownerColumn] = $this->getUserID();
      }
      $deleteEntry = new DeleteEntry($this->model, $this->response);
      return $deleteEntry->deleteEntry($request);
    }

}
