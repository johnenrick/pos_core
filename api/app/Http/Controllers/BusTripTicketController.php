<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusTripTicket as DBItem;
use App\Discount as DiscountDB;

class BusTripTicketController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->foreignTable = ['bus_trip', 'conductor', 'void_bus_trip_tickets'];
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
    if(isset($requestArray['discount_id']) && ($requestArray['discount_id'] == 2 || $requestArray['discount_id'] == 1)){
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
    return $this->createEntry($requestArray, true);
  }
  function update(Request $request){
    $this->rawRequest = $request;
    $requestArray = $request->all();
    if(isset($requestArray['discount_id']) && ($requestArray['discount_id'] == 2 || $requestArray['discount_id'] == 1)){
      $this->singleImageFileUpload = [
        [
          'name' => 'discount_image_proof',
          'path' => 'discount_image_proof',
          'column' => 'discount_image_proof',
          'replace' => true
        ]
      ];
    } else{

      $this->notRequired[] = 'discount_image_proof';
    }
    return $this->updateEntry($requestArray);
  }
  // function dailySalesReport(Request $request){
  //   $requestArray = $request->all();
  //   $discountList = (new DiscountDB())->select(['id', 'description'])->get()->toArray();
  //   $this->aliased = [
  //     'total_total_amount' => 'sum(total_amount)',
  //     'total_payment_adjustment' => 'sum(payment_adjustment)',
  //     'total_discount_amount' => 'sum(discount_amount)',
  //     'date' => 'CAST(bus_trips.created_at AS DATE)'
  //   ];
  //   for($x = 0; $x < count($discountList); $x++){
  //     $this->aliased['total_' . str_replace(' ', '_', strtolower($discountList[$x]['description'])) . '_discount_amount'] = 'sum(CASE WHEN discount_id = ' . $discountList[$x]['id'] . ' THEN discount_amount ELSE 0 END)';
  //   }
  //   $this->leftJoinChildTable = ['bus_trips' => ''];
  //   $this->groupByColumn = array('CAST(created_at AS DATE)');
  //   return $this->retrieveEntry($requestArray);
  // }
  function batchCreate(Request $requests){
    $requestArray = $requests->all();
    if(!isset($requestArray['entries'])){
      $this->response['data'] = false;
      $this->response['error'][] = array(
        'status' => 1000,
        'message' => 'No Entries Sent.'
      );
      return $this->output();
    }
    $responses = array();
    foreach($requestArray['entries'] as $request){
      if(isset($request['discount_id']) && ($request['discount_id'] == 2 || $request['discount_id'] == 1)){
        $this->singleImageFileUpload = [
          [
            'name' => 'discount_image_proof',
            'path' => 'discount_image_proof',
            'column' => 'discount_image_proof',
            'replace' => true
          ]
        ];
        $this->notRequired = array();
      }else{
        $this->singleImageFileUpload = [];
        $this->notRequired[] = 'discount_image_proof';
      }
      $this->response = array(
        "data" => null,
        "error" => array(),// {status, message}
        "response_type" => 'json',
      );
      $response = $this->createEntry($request);
      $responses[] = $response;
    }
    $this->response['data'] = $responses;
    return $this->output();
  }
}
