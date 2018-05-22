<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Discounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('discounts', function(Blueprint $table){
        $table->increments('id');
        $table->string('description');
        $table->tinyInteger('type')->comment('1 - percent, 2 - amount, 3 - variable percentage, 4 - variable amount');
        $table->tinyInteger('application')->comment('1 - per item, 2 - per transaction, 3 - both');
        $table->boolean('restricted');
        $table->double('value');
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
