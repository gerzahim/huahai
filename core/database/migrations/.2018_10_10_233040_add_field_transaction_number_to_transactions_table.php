<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldTransactionNumberToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::table('transactions', function(Blueprint $table)
       {
         $table->integer('transaction_number')->after('uuid')->primary()->autoIncrement();
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
       Schema::table('transactions', function (Blueprint $table) {
         $table->dropColumn('transaction_number');
       });
     }
}
