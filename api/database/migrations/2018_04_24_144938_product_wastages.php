<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductWastages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('product_quantity_adjustments', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedInteger('product_id');
        $table->unsignedInteger('quantity_adjustment_type_id');
        $table->double('quantity');
        $table->string('remarks');
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
