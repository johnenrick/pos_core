<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusTripExpense as DBItem;

class BusTripExpenseController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
    $this->foreignTable = ['bus_trip'];
    $this->notRequired = array('remarks');
  }
}
