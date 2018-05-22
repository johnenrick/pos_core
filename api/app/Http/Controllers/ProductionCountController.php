<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductionCount as DBItem;

class ProductionCountController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
  }
}
