<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoidBusTripTicket extends APIModel
{
  public function void_request_reason(){
    return $this->belongsTo('App\VoidRequestReason');// Get the pending only
  }
}
