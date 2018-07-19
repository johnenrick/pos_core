<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RouteStop as DBItem;

class RouteStopController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
    $this->foreignTable = ['route'];
  }
}
