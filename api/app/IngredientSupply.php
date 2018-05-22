<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientSupply extends APIModel
{
  public function  ingredient(){
    return $this->belongsTo('App\Ingredient','ingredient_id');
  }
}
