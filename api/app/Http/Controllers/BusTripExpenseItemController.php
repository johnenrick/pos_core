<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusTripExpenseItem as DBItem;

class BusTripExpenseItemController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
    $this->notRequired = array('default_amount');
  }
}
