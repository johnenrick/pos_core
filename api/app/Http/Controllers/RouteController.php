<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Route as DBItem;

class RouteController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
    $this->validation = [
      'estimated_travel_duration'=> 'numeric',
      'route_stops.*.name'=> 'required',
      'route_stops.*.distance'=> 'required|numeric'
    ];
    $this->notRequired = array('estimated_travel_duration');
    $this->requiredForeignTable = array('route_stops');
    $this->editableForeignTable = array('route_stops');
  }
  public function create(Request $request){
    $requestArray = $request->all();
    if(isset($requestArray['route_stops'])){
      for($x = 0; $x < count($requestArray['route_stops']); $x++){
        $requestArray['route_stops'][$x]['order_number'] = $x;
      }
    }
    return $this->createEntry($requestArray);
  }
  public function update(Request $request){
    $requestArray = $request->all();
    if(isset($requestArray['route_stops'])){
      for($x = 0; $x < count($requestArray['route_stops']); $x++){
        $requestArray['route_stops'][$x]['order_number'] = $x;
      }
    }
    return $this->updateEntry($requestArray);
  }

}
