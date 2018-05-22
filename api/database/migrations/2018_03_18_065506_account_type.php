<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccountType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Schema::create('account_type', function(Blueprint $table){
      //   $table->increments('id');
      //   $table->string('description', 50);
      //   $table->timestamps();
      //   $table->softDeletes();
      // });
      Schema::table('accounts', function(Blueprint $table){
        $table->integer('account_type_id')->after('password');
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
