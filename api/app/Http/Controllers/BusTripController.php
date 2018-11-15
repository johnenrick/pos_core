<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusTrip as DBItem;
use App\BusTripTicket as DBBusTripTicket;
use App\BusTripFuelConsumption as DBBusTripFuelConsumption;
use App\BusTripExpense as DBBusTripExpense;
use App\InspectorReport as DBInspectorReport;
use App\Discount as DiscountDB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

  function busTripSync(Request $request){
    $data = $request->all();
    $validationRules = [
      "bus_trip_code" => "required",
      "bus_id" => "required",
      "route_id" => "required",
      "driver_account_id" => "required",
      "conductor_account_id" => "required",
      "arrival_datetime" => "required",
      // "remarks" => "required",
      "created_at" => "required|date_format:Y-m-d H:i:s",
      "fuel_consumption" => "required|array",
      "fuel_consumption.start_reading" => "required",
      "fuel_consumption.end_reading" => "required",
      "inspector_reports.*.account_id" => "required|exists:accounts,id",
      "inspector_reports.*.start_route_stop_id" => "required|exists:route_stops,id",
      "inspector_reports.*.end_route_stop_id" => "required|exists:route_stops,id",
      "inspector_reports.*.passenger_count" => "required|numeric",
      "inspector_reports.*.remarks" => "required",
      "inspector_reports.*.created_at" => "required|date_format:Y-m-d H:i:s",
      "bus_trip_expenses" => "array",
      "bus_trip_expenses.*.bus_trip_expense_item_id" => "required|exists:bus_trip_expense_items,id",
      "bus_trip_expenses.*.amount" => "required|numeric",
      "bus_trip_expenses.*.created_at" => "required|date_format:Y-m-d H:i:s",
      "bus_trip_tickets" => "required|array",
      "bus_trip_tickets.*.passenger_quantity" => "required",
      "bus_trip_tickets.*.start_route_stop_id" => "required",
      "bus_trip_tickets.*.end_route_stop_id" => "required",
      "bus_trip_tickets.*.total_distance" => "required",
      "bus_trip_tickets.*.total_amount" => "required",
      "bus_trip_tickets.*.cash_tendered" => "required",
      "bus_trip_tickets.*.payment_adjustment" => "required",
      // "bus_trip_tickets.*.remarks" => "required",
      "bus_trip_tickets.*.created_at" => "required"
    ];
    $validator = Validator::make($data, $validationRules);
    if($validator->fails()){
      $this->response["error"][] = array(
        'status' => 100,
        'message' => $validator->errors()->toArray()
      );
    }else{

      $this->response["data"] = [
        "id" => false,
        "bus_trip_tickets" => []
      ];
      $this->model->bus_id = $data["bus_id"];
      $this->model->route_id = $data["route_id"];
      $this->model->driver_account_id = $data["driver_account_id"];
      $this->model->conductor_account_id = $data["conductor_account_id"];
      $this->model->arrival_datetime = $data["arrival_datetime"];
      $this->model->remarks = isset($data["remarks"]) ? $data["remarks"] : "";
      $this->model->created_at = $data["created_at"];
      if($this->model->save()){
        $this->response["data"]["id"] = $this->model->id;
        /*Fuel Consumption*/
        $this->response["data"]["fuel_consumption"] = $this->createBusTripFuelConsumption($this->response["data"]["id"], $data["fuel_consumption"]['start_reading'], $data['fuel_consumption']['end_reading'], $data['arrival_datetime']);
        /*Inspector Report*/
        if(isset($data["inspector_reports"]) && count($data["inspector_reports"])){
          $this->response["data"]["inspector_reports"] = [];
          foreach($data['inspector_reports'] as $inspectorReport){
            $this->response["data"]["inspector_reports"][] = [
              "id" => $this->createInspectorReport($this->response["data"]["id"], $inspectorReport),
            ];

          }
        }else{
          $this->response["data"]["inspector_reports"] = isset($this->response["data"]["inspector_reports"]);

        }
        /*Expenses*/
        $this->response["data"]["bus_trip_expenses"] = [];
        foreach($data['bus_trip_expenses'] as $bustripExpense){
          $this->response["data"]["bus_trip_expenses"][] = [
            "id" => $this->createBusTripExpense($this->response["data"]["id"], $bustripExpense["bus_trip_expense_item_id"], $bustripExpense['amount'], isset($bustripExpense['remarks']) ? $bustripExpense['remarks'] : "", $bustripExpense['created_at']),
          ];

        }
        /*Tickets*/
        $this->response["data"]["bus_trip_tickets"] = [];
        foreach($data['bus_trip_tickets'] as $bustripTicket){
          $this->response["data"]["bus_trip_tickets"][] = [
            "id" => $this->createBusTripTicket($this->response["data"]["id"], $data["conductor_account_id"], $bustripTicket),
            "code" => $bustripTicket['code']
          ];

        }
      }
    }
    return $this->output();
  }
  public function createInspectorReport($busTripID, $inspectorReport){
    $model = new DBInspectorReport();
    $model->bus_trip_id = $busTripID;
    $model->account_id = $inspectorReport['account_id'];
    $model->start_route_stop_id = $inspectorReport['start_route_stop_id'];
    $model->end_route_stop_id = $inspectorReport['end_route_stop_id'];
    $model->passenger_count = $inspectorReport['passenger_count'];
    $model->remarks = isset($inspectorReport['remarks']) ? $inspectorReport['remarks'] : "";
    $model->created_at = $inspectorReport['created_at'];
    if($model->save()){
      return $model->id;
    }else{
      return false;
    }
  }
  public function createBusTripExpense($busTripID, $busTripExpenseItemID, $amount, $remarks, $createdAt){
    $model = new DBBusTripExpense();
    $model->bus_trip_id = $busTripID;
    $model->bus_trip_expense_item_id = $busTripExpenseItemID;
    $model->amount = $amount;
    $model->remarks = $remarks;
    $model->created_at = $createdAt;
    if($model->save()){
      return $model->id;
    }else{
      return false;
    }
  }
  public function createBusTripFuelConsumption($busTripID, $startReading, $endReading, $createdAt){
    $model = new DBBusTripFuelConsumption();
    $model->bus_trip_id = $busTripID;
    $model->start_reading = $startReading;
    $model->end_reading = $endReading;
    $model->created_at = $createdAt;
    if($model->save()){
      return $model->id;
    }else{
      return false;
    }
  }
  public function createBusTripTicket($busTripID, $conductorID, $ticketData){
    $model = new DBBusTripTicket();
    $model->bus_trip_id = $busTripID;
    $model->conductor_account_id = $conductorID;
    $model->passenger_quantity = $ticketData["passenger_quantity"];
    $model->start_route_stop_id = $ticketData["start_route_stop_id"];
    $model->end_route_stop_id = $ticketData["end_route_stop_id"];
    $model->total_distance = $ticketData["total_distance"];
    $model->total_amount = $ticketData["total_amount"];
    $model->cash_tendered = $ticketData["cash_tendered"];
    $model->payment_adjustment = $ticketData["payment_adjustment"];
    $model->remarks = $ticketData["remarks"];
    $model->created_at = $ticketData["created_at"];
    if($model->save()){
      return $model->id;
    }else{
      return false;
    }
  }
}
