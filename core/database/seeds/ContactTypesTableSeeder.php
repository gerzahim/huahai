<?php

use Illuminate\Database\Seeder;

class ContactTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('types_contact')->delete();
        
        \DB::table('types_contact')->insert(array (
            0 => 
            array (
                'id' => '1',
                'name' => 'Clients ',
                'created_at' => '2016-07-25 15:14:06',
                'updated_at' => '2016-08-02 14:38:36',
            ),
            1 => 
            array (
                'id' => '2',
                'name' => 'Vendors',
                'created_at' => '2016-07-25 14:57:45',
                'updated_at' => '2016-07-25 15:11:17',
            ),
        ));        
    }
}
