<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VoidRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('void_bus_trip_tickets', function(Blueprint $table){
          $table->increments('id');
          $table->unsignedInteger('bus_trip_ticket_id');
          $table->unsignedInteger('account_id');
          $table->string('remarks');
          $table->tinyInteger('is_approved')->comment('0 - pending, 1 - approved, 2 - disapproved');
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
