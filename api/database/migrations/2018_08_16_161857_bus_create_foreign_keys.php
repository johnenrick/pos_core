<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BusCreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus_trips', function(Blueprint $table){
          $table->foreign('bus_id')->references('id')->on('buses');
          $table->foreign('route_id')->references('id')->on('routes');
          $table->foreign('driver_account_id')->references('id')->on('accounts');
          $table->foreign('conductor_account_id')->references('id')->on('accounts');
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
