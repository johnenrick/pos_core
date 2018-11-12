<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BusTripExpense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('bus_trip_expenses', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedInteger('bus_trip_id');
        $table->unsignedInteger('bus_trip_expense_item_id');
        $table->float('amount');
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
