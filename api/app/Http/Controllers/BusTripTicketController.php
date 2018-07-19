<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusTripTicket as DBItem;

class BusTripTicketController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->foreignTable = ['bus_trip', 'conductor'];
    $this->notRequired = array('discount_id', 'discount_amount', 'status', 'remarks', 'payment_adjustment');
    // $this->replaceSessionData = array(
    //   'conductor_account_id' => 'user_id'
    // );
    if($this->getUserAccountType() !== 1){
      $this->ownerColumn = 'conductor_account_id';
    }
  }
  function create(Request $request){
    $this->ownerColumn = 'conductor_account_id';
    $this->rawRequest = $request;
    $requestArray = $request->all();
    $this->response['debug'][] = $requestArray;
    $this->response['debug'][] = $this->rawRequest->hasFile('discount_image_proof');
    if(isset($requestArray['discount_id']) && $requestArray['discount_id'] == 2){
      $this->singleImageFileUpload = [
        [
          'name' => 'discount_image_proof',
          'path' => 'discount_image_proof',
          'column' => 'discount_image_proof',
          'replace' => true
        ]
      ];
    }else{
      $this->notRequired[] = 'discount_image_proof';
    }
    return $this->createEntry($requestArray);
  }
  function update(Request $request){
    $this->rawRequest = $request;
    $requestArray = $request->all();
    if(isset($requestArray['discount_id']) && $requestArray['discount_id'] == 2){
      $this->singleImageFileUpload = [
        [
          'name' => 'discount_image_proof',
          'path' => 'discount_image_proof',
          'column' => 'discount_image_proof',
          'replace' => true
        ]
      ];
    }else{
      $this->notRequired[] = 'discount_image_proof';
    }
    return $this->updateEntry($requestArray);
  }
  function dailySalesReport(Request $request){
    $this->aliased = [
      'total_total_amount' => 'sum(total_amount)',
      'date' => 'CAST(created_at AS DATE)'
    ];
    $this->groupByColumn = array('CAST(created_at AS DATE)');
    return $this->retrieveEntry($request->all());
  }
}
