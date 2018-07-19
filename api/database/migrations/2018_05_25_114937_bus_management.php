<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BusManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('buses', function(Blueprint $table){
        $table->increments('id');
        $table->string('description');
        $table->unsignedInteger('bus_type_id');
        $table->char('plate_number', 10);
        $table->integer('passenger_capacity');
        $table->integer('weight_capacity');
        $table->text('remarks');
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
