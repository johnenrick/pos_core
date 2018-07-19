<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BusTrip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('bus_trips', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedInteger('bus_id');
        $table->unsignedInteger('route_id');
        $table->unsignedInteger('driver_account_id');
        $table->unsignedInteger('conductor_account_id')->nullable();
        $table->timestamp('arrival_datetime')->nullable();
        $table->string('remarks')->nullable();
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
