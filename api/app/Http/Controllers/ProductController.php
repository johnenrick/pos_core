<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product as DBItem;

class ProductController extends APIController
{
  function __construct(){
    $this->model = new DBItem();
    $this->APIControllerConstructor();
    $this->notRequired = array('short_name');
    $this->requiredForeignTable = array('product_category');
  }
}
