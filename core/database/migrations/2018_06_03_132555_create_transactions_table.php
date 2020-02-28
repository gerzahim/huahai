<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('uuid', 36)->primary();
            $table->mediumText('transactions_items');  
            //$table->string('product_id', 36)->index('transactions_products_id_foreign');
            //$table->foreign('product_id')->references('uuid')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('transaction_types_id', 36)->index('transactions_transactions_types_id_foreign');
            $table->foreign('transaction_types_id')->references('uuid')->on('transactions_types')->onUpdate('CASCADE')->onDelete('CASCADE');
            //$table->date('transaction_date');
            $table->enum('type_contact', array('1','0'))->default('0')->comment('0:Client,1:Vendor');
            $table->string('contacts_id', 36)->nullable();

            $table->string('couriers_id', 36)->index('couriers_id_foreign');
            $table->foreign('couriers_id')->references('uuid')->on('couriers')->onUpdate('CASCADE')->onDelete('CASCADE'); 
            $table->string('tracking_number', 36)->nullable();     
            $table->enum('transaction_types_in', array('1','0'))->default('0')->comment('0:Purchase,1:RMA');                            
            $table->string('number_types_in', 36);
            $table->string('bol', 36)->nullable();
            $table->string('batch_number', 36)->nullable();
            $table->string('user_id', 36)->index('transactions_user_id_foreign');
            $table->foreign('user_id')->references('uuid')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('quantity')->default(0);
            $table->text('notes', 65535);
            $table->timestamps();



/*
 php artisan make:migration create_courier_table

 php artisan make:model Courier -m
        type clients 
         clients
         vendors

        transaction_types_id
        type_contact
        contacts_id
        user_id

        Currier ( ups, DHL, etc.. )
        Tracking number 
        Type In  Reason( RMA, Purchase)
        Code_TypeIn  ( RMA AUTOGENERATE, empty) 
        Bill of Number BOL
        batch // Batch Number 
        Note
        Date In

        transactions_items

        transaction_id
        product_id
        quantity






*/



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
