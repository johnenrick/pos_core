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
    $this->groupByColumn = array('product_id');
    $this->select = array('product_id');
    return $this->output($this->retrieveEntry($request->all()));
  }
}
