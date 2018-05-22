<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\OrderProduct as DBItem;

class OrderProductController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
    $this->requiredForeignTable = ['product'];

  }
  function productSalesSummary(Request $request){
    $this->aliased = [
      'total_sale_price' => 'sum(sale_price)',
      'total_quantity' => 'sum(quantity)'
    ];
    $this->model = $this->model::groupBy('product_id');
    $this->model = $this->model->addSelect('product_id');
    //$this->model = $this->model->addSelect(DB::raw(' as ``'))->orderBy(DB::raw('sum(sale_price)'), 'ASC');
    $this->rawRequest = $request;
    // $this->response['debug'][] = $request->all();
    // $this->response['data'] = $this->model->get()->toArray();
    return $this->output($this->retrieveEntry($request->all()));
  }
}
