<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusTrip as DBItem;

class BusTripController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
    $this->foreignTable = ['bus', 'driver', 'conductor', 'bus_trip_ticket', 'route', 'void_bus_trip_ticket'];
    $this->notRequired = array('arrival_datetime', 'remarks', 'conductor_account_id');
    if($this->getUserAccountType() != 1){
      $this->ownerColumn = 'conductor_account_id';
    }
  }
  function routeSalesSummary(Request $request){
    $requestArray = $request->all();
    $this->aliased = [
      'total_amount' => 'sum(bus_trip_tickets.total_amount)',
      'total_net_amount' => 'sum(bus_trip_tickets.payment_adjustment) + sum(bus_trip_tickets.total_amount)',
      'total_passenger_quantity' => 'sum(bus_trip_tickets.passenger_quantity)',
    ];
    $requestArray['with_foreign_table'] = array('route');

    $this->groupByColumn = array('route_id');
    $this->leftJoinChildTable = array('bus_trip_tickets' => array());
    $this->select = array('route_id');
    // $this->select = array('route_id', 'bus_trip_tickets.total_amount', 'bus_trip_tickets.created_at');
    return $this->output($this->retrieveEntry($requestArray));
  }
  function routeDailySales(Request $request){
    $requestArray = $request->all();
    $this->aliased = [
      'total_amount' => 'sum(bus_trip_tickets.total_amount)',
      'total_payment' => 'sum(bus_trip_tickets.payment_adjustment) + sum(bus_trip_tickets.total_amount)',
      'total_passenger_quantity' => 'sum(bus_trip_tickets.passenger_quantity)',
      'date' => 'CAST(bus_trips.created_at AS DATE)'
    ];
    $requestArray['with_foreign_table'] = array('route');
    $this->groupByColumn = array('route_id', 'CAST(bus_trips.created_at AS DATE)');
    $this->leftJoinChildTable = array('bus_trip_tickets' => array());
    $this->select = array('route_id');
    $this->response = $this->retrieveEntry($requestArray);
    if($this->response['data']){
      $this->response['data'] = collect($this->response['data'])->groupBy('route_id');
    }
    return $this->response;
  }
  function busColectionSummary(Request $request){
    $requestArray = $request->all();
    $this->aliased = [
      'total_amount' => 'sum(bus_trip_tickets.total_amount)',
      'total_payment' => 'sum(bus_trip_tickets.payment_adjustment) + sum(bus_trip_tickets.total_amount)',
      'total_passenger_quantity' => 'sum(bus_trip_tickets.passenger_quantity)',
    ];
    $requestArray['with_foreign_table'] = array('bus');
    $this->groupByColumn = array('bus_id');
    $this->leftJoinChildTable = array('bus_trip_tickets' => array());
    $this->select = array('bus_id');
    // $this->select = array('route_id', 'bus_trip_tickets.total_amount', 'bus_trip_tickets.created_at');
    return $this->output($this->retrieveEntry($requestArray));
  }
}
