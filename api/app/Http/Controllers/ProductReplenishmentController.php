<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductReplenishment as DBItem;

class ProductReplenishmentController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
  }
}
