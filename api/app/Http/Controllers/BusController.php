<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bus as DBItem;
use App\BusTrip;
class BusController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
    $this->foreignTable = ['bus_type'];
  }
  function retrieve(Request $request){
    $requestArray = $request->all();
    if(isset($requestArray['is_active'])){
      $busTripListModel = ((new BusTrip())->where('arrival_datetime', NULL)); // retrieve active bus trips
      $busTripListModel = $busTripListModel->groupBy('bus_id')->select('bus_id');
      $busTripList = $busTripListModel->get()->toArray();
      if(count($busTripList)){
        $busTripList = collect($busTripList)->pluck('bus_id');
        if(!isset($requestArray['condition'])){
          $requestArray['condition'] = [];
        }
        $requestArray['condition'][] = array(
          'column' => 'id',
          'value' => $busTripList,
          'clause' => filter_var($requestArray['is_active'], FILTER_VALIDATE_BOOLEAN) ? '=' : '!='
        );
      }

    }
    return $this->retrieveEntry($requestArray);
  }
}
