<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusType as DBItem;

class BusTypeController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
  }
}
