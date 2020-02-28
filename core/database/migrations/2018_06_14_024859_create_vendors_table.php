<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->string('uuid', 36)->primary();
            $table->string('vendor_no');
            $table->string('name');
            $table->string('email');
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
            $table->string('phone');
            $table->string('mobile');
            $table->string('website');
            $table->text('notes', 65535);
            $table->string('photo');
            $table->string('remember_token', 100);
            $table->timestamps();
        });
        // then I add the increment_num "manually"
        DB::statement('ALTER Table vendors add increment_num INTEGER NOT NULL UNIQUE AUTO_INCREMENT;');        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
