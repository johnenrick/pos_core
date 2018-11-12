<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InspectorReport as DBItem;

class InspectorReportController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
    $this->foreignTable = ['bus_trip', 'account', 'system_passenger_count'];
    $this->leftJoinChildTable = ['bus_trips.bus' => null];
    $this->notRequired = array('remarks');
  }
  public function batchCreate(Request $request){
    // $this->rawRequest = $request;
    // $this->validation = [
    //   "bus_trip_id" => "required",
    //   "account_id"
    // ];

  }
}
