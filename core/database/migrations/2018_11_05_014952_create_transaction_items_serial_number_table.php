<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionItemsSerialNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /*
      Schema::create('transaction_items_serial_numbers', function (Blueprint $table) {
          $table->string('uuid', 36)->primary();
          $table->string('transaction_id', 36)->index('transaction_items_serial_numbers_transactions_foreign');
          $table->foreign('transaction_id')->references('uuid')->on('transactions')->onUpdate('CASCADE')->onDelete('CASCADE');
          $table->string('transaction_item_id', 36)->index('transaction_items_serial_numbers_transaction_items_foreign');
          $table->foreign('transaction_item_id')->references('uuid')->on('transaction_items')->onUpdate('CASCADE')->onDelete('CASCADE');
          $table->string('product_id', 36)->index('transaction_items_serial_numbers_products_id_foreign');
          $table->foreign('product_id')->references('uuid')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
          $table->string('serial_number', 255);
          $table->timestamps();
      });
      */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      	Schema::drop('transaction_items_serial_numbers');
    }
}
