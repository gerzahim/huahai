<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('products', function(Blueprint $table)
      {
        $table->string('dimension', 255)->after('model')->comment('(Length, width, height)')->nullable();
        $table->string('weight', 255)->after('dimension')->nullable();
        $table->double('price')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['dimension', 'weight']);
    });
    }
}
