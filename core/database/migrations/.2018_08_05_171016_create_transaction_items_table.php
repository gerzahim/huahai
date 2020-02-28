<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_items', function (Blueprint $table) {
          $table->string('uuid', 36)->primary();
          $table->string('transaction_id', 36)->index('transaction_items_transactions_foreign');
          $table->foreign('transaction_id')->references('uuid')->on('transactions')->onUpdate('CASCADE')->onDelete('CASCADE');
          $table->string('product_id', 36)->index('transaction_items_products_id_foreign');
          $table->foreign('product_id')->references('uuid')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
          $table->integer('quantity')->default(0);
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_items');
    }
}
