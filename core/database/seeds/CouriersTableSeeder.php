<?php

use Illuminate\Database\Seeder;

class CouriersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        \DB::table('couriers')->delete();
        
        \DB::table('couriers')->insert(array (
            0 => 
            array (
                'uuid' => '0055b964-9cf8-4ad3-b9ec-d34779cc96bf',
                'name' => 'DHL',
                'created_at' => '2018-04-30 15:30:39',
                'updated_at' => '2018-06-03 15:42:37',
            ),
            
        ));        
    }
}


