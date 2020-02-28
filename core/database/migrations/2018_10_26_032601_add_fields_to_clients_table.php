<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('clients', function(Blueprint $table)
      {
        $table->string('contact_person')->after('photo')->nullable();
        $table->string('ein_number')->after('contact_person')->nullable();
        $table->string('resale_tax')->after('ein_number')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('clients', function (Blueprint $table) {
        $table->dropColumn('contact_person');
        $table->dropColumn('ein_number');
        $table->dropColumn('resale_tax');
      });
    }
}
