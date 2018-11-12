<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VoidRequestReason as DBItem;

class VoidRequestReasonController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
  }
}
