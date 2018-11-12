<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InspectorReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('inspector_reports', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedInteger('bus_trip_id');
        $table->unsignedInteger('account_id')->comment("inspector_id");
        $table->unsignedInteger('start_route_stop_id');
        $table->unsignedInteger('end_route_stop_id');
        $table->unsignedInteger('passenger_count');
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
