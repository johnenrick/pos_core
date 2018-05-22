<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discount as DBItem;

class ProductIngredientController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
  }
}
