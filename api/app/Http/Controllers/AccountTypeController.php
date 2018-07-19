<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountType as DBItem;

class AccountTypeController extends APIController
{
  function __construct(){
     $this->model = new DBItem();
     $this->APIControllerConstructor();
     
   }
}
