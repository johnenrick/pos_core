<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusType as DBItem;

class BusTypeController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->validation = array(
      "description" => "string|max:150",
      "base_price" => "numeric",
      "price_per_distance" => "numeric"
    );
  }
}
