<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Order as DBItem;

class OrderController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->editableForeignTable = ['order_products'];
    $this->validation = array(
      'total_price' => 'numeric',
      'cash_tendered' => 'numeric'
    );
    $this->APIControllerConstructor();
  }
  function dailySalesReport(Request $request){
    $this->aliased = [
      'total_price' => 'sum(total_price)',
      'date' => 'CAST(created_at AS DATE)'
    ];
    $this->model = $this->model->groupBy(DB::raw('CAST(created_at AS DATE)'));
    //$this->model = $this->model->addSelect(DB::raw(' as ``'))->orderBy(DB::raw('sum(sale_price)'), 'ASC');
    $this->rawRequest = $request;
    $this->retrieveEntry($request->all());
    // $this->response['data'] = $this->model->get()->toArray();
    return $this->output();
  }
}
