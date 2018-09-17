<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusTrip as DBItem;
use App\BusTripTicket as DBBusTripTicket;
use App\Discount as DiscountDB;

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
  function saleSummary(Request $request){
    $this->ownerColumn = null;
    $discountList = (new DiscountDB())->select(['id', 'description'])->get()->toArray();
    $requestArray = $request->all();
    $this->aliased = [
      'total_total_amount' => 'sum(bus_trip_tickets.total_amount)',
      'total_payment_adjustment' => 'sum(bus_trip_tickets.payment_adjustment)',
      'total_discount_amount' => 'sum(bus_trip_tickets.discount_amount)',
      'total_passenger_quantity' => 'sum(bus_trip_tickets.passenger_quantity)',
      'entry_count' => 'count(bus_trip_tickets.id)'
    ];
    for($x = 0; $x < count($discountList); $x++){
      $this->aliased['total_' . str_replace(' ', '_', strtolower($discountList[$x]['description'])) . '_discount_amount'] = 'sum(CASE WHEN discount_id = ' . $discountList[$x]['id'] . ' THEN discount_amount ELSE 0 END)';
    }
    $this->rightJoinChildTable = array('bus_trip_tickets' => array());
    $groupBy = isset($requestArray['group_by']) ? (gettype($requestArray['group_by']) == 'array' ?  $requestArray['group_by'] :  [$requestArray['group_by']]) : []; // make $groupBy an array
    $this->groupByColumn = array();

    if(in_array('route', $groupBy)){ // group the sales by routes
      $this->groupByColumn[] = 'route_id';
      $this->leftJoinChildTable['routes'] = '';
      $this->select = ['route_id'];
      $this->aliased['route_description'] = 'routes.description';
      // $this->aliased['date'] = 'CAST(bus_trips.created_at AS DATE)';
    }
    if(in_array('bus', $groupBy)){ // group the sales by routes
      $this->groupByColumn[] = 'bus_id';
      $this->leftJoinChildTable['buses'] = '';
      $this->select = ['bus_id'];
      $this->aliased['bus_description'] = 'buses.description';
    }

    if(in_array('monthly', $groupBy)){ // group the sales by date
      $groupByColumn = 'MONTH(CAST(bus_trips.created_at as DATE))';
      $this->groupByColumn[] = $groupByColumn;
      $this->aliased['date_month'] = $groupByColumn;
    }
    if(in_array('yearly', $groupBy)){ // group the sales by date
      $groupByColumn = 'YEAR(CAST(bus_trips.created_at as DATE))';
      $this->groupByColumn[] = $groupByColumn;
      $this->aliased['date_year'] = $groupByColumn;
    }


    if(in_array('date', $groupBy)){ // group the sales by date
      $groupByColumn = 'CAST(bus_trips.created_at AS DATE)';
      $this->groupByColumn[] = $groupByColumn;
      $this->aliased['date'] = $groupByColumn;
    }
    // $this->select = array('route_id', 'bus_trip_tickets.total_amount', 'bus_trip_tickets.created_at');

    $this->response = $this->retrieveEntry($requestArray);
    if($this->response['data'] && isset($requestArray['collect_result']) ){ // collect the result yearly
      if($requestArray['collect_result'] == 'date_year'){
        $this->response['data'] = collect($this->response['data'])->groupBy('date_year');
      }else if($requestArray['collect_result'] == 'route_id'){
        $this->response['data'] = collect($this->response['data'])->groupBy('route_id');
      }
    }
    return $this->output($this->response);
  }
  function routeDailySales(Request $request){
    $requestArray = $request->all();
    $this->aliased = [
      'total_amount' => 'sum(bus_trip_tickets.total_amount)',
      'total_payment' => 'sum(bus_trip_tickets.payment_adjustment) + sum(bus_trip_tickets.total_amount)',
      'total_passenger_quantity' => 'sum(bus_trip_tickets.passenger_quantity)',
      'date' => 'CAST(bus_trips.created_at AS DATE)'
    ];
    // $requestArray['with_foreign_table'] = array('route');
    $this->groupByColumn = array('route_id', 'CAST(bus_trips.created_at AS DATE)');
    $this->leftJoinChildTable = array('bus_trip_tickets' => array(), 'routes' => array());
    $this->select = array('route_id', 'routes.description');
    $this->response = $this->retrieveEntry($requestArray);
    if($this->response['data']){
      $this->response['data'] = collect($this->response['data'])->groupBy('route_id');
    }
    return $this->response;
  }
  function busCollectionSummary(Request $request){
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
