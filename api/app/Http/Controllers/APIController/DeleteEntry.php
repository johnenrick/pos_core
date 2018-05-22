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

class DeleteEntry extends Controller
{
  protected $response = null;
  protected $model = null;
  function __construct($model, $response){
    $this->response = $response;
    $this->model = $model;
  }

  public function test(){
    $response['debug']['test_mod'] = 'test';
    return $this->test . ' world';
  }
  public function deleteEntry($request){
    $validator = Validator::make($request, ["id" => "required"]);
    if ($validator->fails()) {
      $this->response["error"]["status"] = 101;
      $this->response["error"]["message"] = $validator->errors()->toArray();
      return false;
    }
    $this->response["data"] = $this->model->destroy($request["id"]);
    return $this->response;
  }
}