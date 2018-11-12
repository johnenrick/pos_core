<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyVoidRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('void_bus_trip_tickets', function(Blueprint $table){
          $table->unsignedInteger("void_request_reason_id")->after("bus_trip_ticket_id");
          $table->char("batch_code", 100)->after("void_request_reason_id")->nullable();
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
