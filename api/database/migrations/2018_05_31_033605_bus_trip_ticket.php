<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BusTripTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('bus_trip_tickets', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedInteger('bus_trip_id');
        $table->unsignedInteger('conductor_account_id');
        $table->unsignedInteger('passenger_quantity');
        $table->unsignedInteger('start_route_stop_id');
        $table->unsignedInteger('end_route_stop_id');
        $table->float('total_distance')->comment('In Kilometer');
        $table->float('total_amount');
        $table->double('payment_adjustment')->default(0);
        $table->double('cash_tendered')->default(0);
        $table->unsignedInteger('discount_id')->nullable();
        $table->unsignedInteger('discount_amount')->nullable();
        $table->string('discount_image_proof')->nullable();
        $table->tinyInteger('status')->default(1)->comment('1 - success, 2 - voided');
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
