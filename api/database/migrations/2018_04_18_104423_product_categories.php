<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('product_categories', function(Blueprint $table){
        $table->increments('id');
        $table->string('description');
        $table->timestamps();
        $table->softDeletes();
      });
      Schema::table('products', function(Blueprint $table){
        $table->unsignedInteger('product_category_id')->after('description');
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
