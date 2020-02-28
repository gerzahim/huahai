<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->string('uuid', 36)->primary();
			$table->string('name')->unique();
			$table->string('code')->unique();
			$table->string('model')->nullable();
			$table->string('category_id');
			$table->text('description', 65535);
			$table->float('price', 15);
			$table->integer('quantity')->default(0);
			$table->string('image');
			$table->timestamps();
		});
	}

        /*
        code
        name
        model
        price
        category_id
        description
        qty 
        product_image

        */
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
