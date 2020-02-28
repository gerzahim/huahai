<?php

use Illuminate\Database\Seeder;

class TransactionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        \DB::table('transaction_types')->delete();
        
        \DB::table('transaction_types')->insert(array (
            0 => 
            array (
                'uuid' => '27f41653-a968-4885-8000-7aaf4efc3835',
                'type' => 'out ',
                'name' => 'out ',
                'description' => 'Outbound transaction',
                'created_at' => '2016-07-25 15:14:06',
                'updated_at' => '2016-08-02 14:38:36',
            ),
            1 => 
            array (
                'uuid' => '27f41653-a968-4885-8000-7aaf4efc3836',
                'type' => 'in ',
                'name' => 'In ',
                'description' => 'Inbound transaction',
                'created_at' => '2016-07-25 14:57:45',
                'updated_at' => '2016-07-25 15:11:17',
            ),
        ));        
    }
}

