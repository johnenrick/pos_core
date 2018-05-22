<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('product_audits', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedInteger('product_id');
        $table->double('production_count_quantity');
        $table->double('quantity_adjustments');
        $table->double('quantity_sold');
        $table->double('inventory_value');
        $table->double('product_sales');
        $table->string('remarks');
        $table->timestamp('audit_started');
        $table->timestamp('audit_ended');
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
