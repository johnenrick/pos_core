<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BusTripTicketForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('bus_trip_tickets', function(Blueprint $table){
        $table->foreign('bus_trip_id')->references('id')->on('bus_trips');
        $table->foreign('conductor_account_id')->references('id')->on('accounts');
        $table->foreign('start_route_stop_id')->references('id')->on('route_stops');
        $table->foreign('end_route_stop_id')->references('id')->on('route_stops');
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
