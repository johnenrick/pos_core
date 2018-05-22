<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IngredientSupply as DBItem;

class IngredientSupplyController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->foreignTable = ['ingredient'];
    $this->APIControllerConstructor();
  }
}
