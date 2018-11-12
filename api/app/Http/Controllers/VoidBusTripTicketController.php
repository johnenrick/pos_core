<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VoidBusTripTicket as DBItem;
use App\BusTripTicket;

class VoidBusTripTicketController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->notRequired = array('account_id', 'is_approved', "batch_code");
    $this->defaultValue = array(
      'is_approved' => 0
    );
    $this->foreignTable = array(
      "void_request_reason"
    );
    // if($this->getUserAccountType() != 1){
      $this->ownerColumn = 'account_id';
    // }
  }
  public function create(Request $request){
    $requestArray = $request->all();
    $requestArray['is_approved'] = 0;
    return $this->createEntry($requestArray);
  }
  public function update(Request $request){
    $requestArray = $request->all();
    if(isset($requestArray['id']) && filter_var($requestArray['is_approved'] , FILTER_VALIDATE_BOOLEAN) && isset($requestArray['bus_trip_ticket_id'])){
      $busTripTicket = (new BusTripTicket())->find($requestArray['bus_trip_ticket_id']);
      $busTripTicket->status = 2;
      $busTripTicket->save();
      (new BusTripTicket())->where('id', $requestArray['bus_trip_ticket_id'] )->delete();
    }
    return $this->updateEntry($requestArray);
  }
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
