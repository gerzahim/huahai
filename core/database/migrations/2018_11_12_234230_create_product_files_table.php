<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_files', function(Blueprint $table)
		{
            $table->string('uuid', 36)->primary();
            $table->string('product_id', 36)->index('transaction_items_serial_numbers_products_id_foreign');
            $table->foreign('product_id')->references('uuid')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->string('filename');
			$table->string('original_name');
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
        Schema::drop('product_files');
    }
}
