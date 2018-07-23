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
          'account_information.first_name' => 'max:30|String',
          'account_information.middle_name' => 'max:30|String',
          'account_information.last_name' => 'max:30|String'
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
      if(array_key_exists('password', $requestArray) && strlen($requestArray['password']) === 0){
        unset($requestArray['password']);
      }else if(array_key_exists('password', $requestArray)){
        $requestArray['password'] = Hash::make($requestArray['password']);
      }
      return $this->updateEntry($requestArray);
    }
    public function retrieve(Request $request){
      $requestArray = $request->all();
      if(isset($requestArray['with_foreign_table']) && in_array('account_information', $requestArray['with_foreign_table'])){
        $this->leftJoinChildTable = ['account_informations' => ''];
        $this->aliased = [
          'full_name' => 'CONCAT(COALESCE(account_informations.first_name, ""), " ", COALESCE(account_informations.middle_name,""), " ", COALESCE(account_informations.last_name, ""))'
        ];
        $this->select = ['accounts.*'];
      }
      return $this->retrieveEntry($requestArray);
    }
}
