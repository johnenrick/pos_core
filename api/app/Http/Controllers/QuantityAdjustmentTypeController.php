<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuantityAdjustmentType as DBItem;

class QuantityAdjustmentTypeController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
    $this->notRequired = array(
      'remarks'
    );
  }
}
