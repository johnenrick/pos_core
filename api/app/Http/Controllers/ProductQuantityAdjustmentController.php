<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductQuantityAdjustment as DBItem;

class ProductQuantityAdjustmentController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
  }
}
