<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory as DBItem;

class ProductCategoryController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
  }
}
