<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VoidBusTripTicket as DBItem;
use App\BusTripTicket;

class VoidBusTripTicketController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->notRequired = array('account_id', 'is_approved');
    if($this->getUserAccountType() != 1){
      $this->ownerColumn = 'account_id';
    }
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
}
