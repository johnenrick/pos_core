<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingredient as DBItem;

class IngredientController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
  }
}
