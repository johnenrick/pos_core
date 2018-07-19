<?php

namespace App\Http\Controllers;

use App\Account;
use App\CompanyBranchEmployee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AccountController extends APIController
{
     function __construct(){
        $this->model = new Account();
        $this->validation = array(
          "email" => "unique:accounts|email",
          "username"  => "unique:accounts",
        );
        $this->editableForeignTable = array(
          'account_information', 'account_type'
        );
        $this->APIControllerConstructor();
    }
    /*
      1. account
      2. account_information
    */

    public function create(Request $request){
     $request = $request->all();
     $request['password'] = Hash::make($request['password']);
     return $this->createEntry($request);
    //  if($this->response['data']){
    //     $accountTypeID = isset($request['account_information']['account_type_id']) ? $request['account_information']['account_type_id'] : false;
    //     if($accountTypeID){
    //       $accountResponseData = $this->response['data'];
    //       $this->model = new CompanyBranchEmployee();
    //       $companyBranchRequest = array(
    //         'company_branch_id' => $this->getUserCompanyBranchID(),
    //         'identification_number' => $accountResponseData['id'], // dummy id
    //         'account_id' => $accountResponseData['id']
    //       );
    //       $this->validation = array();
    //       $this->createEntry($companyBranchRequest);
    //     }
    //  }
    }

    public function update(Request $request){
      $requestArray = $request->all();
      $this->response['debug'][] = $requestArray;
      if(array_key_exists('password', $requestArray) && strlen($requestArray['password']) === 0){
        unset($requestArray['password']);
      }else if(array_key_exists('password', $requestArray)){
        $requestArray['password'] = Hash::make($requestArray['password']);
      }
      $this->response['debug'][] = $requestArray;
      return $this->updateEntry($requestArray);
    }

}
