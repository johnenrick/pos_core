<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixAccountRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('accounts', function(Blueprint $table){
        $table->tinyInteger('status')->default(1)->after('account_type_id');
      });
      Schema::table('account_informations', function(Blueprint $table){
        $table->dropColumn('account_type_id');
      });
      Schema::table('account_types', function(Blueprint $table){
        $table->dropColumn('title');
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
