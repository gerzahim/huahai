<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'uuid' => '205a6cce-67b1-4c5f-a3a3-67abbe7c6d1e',
                'name' => 'GERZAHIM SALAS ',
                'email' => 'RASCE88@GMAIL.COM ',
                'phone' => NULL,
                'username' => 'admin',
                'password' => '$2y$10$DybR1XHAMzJv61JwMVYpxuwSeIVoDtgoRUwQwJqFnsrmiV/NbR1sm',
                'photo' => NULL,
                'role_id' => '5c7f11d2-7091-4d10-aaeb-a9b4e3b76a76',
                'remember_token' => 'gbVpQyiH5Fo3QRKPfRrxsuMOPbs2g6mYjUkJL9JafRTenQh5dVCHcCWImMiM',
                'created_at' => '2018-04-30 15:30:39',
                'updated_at' => '2018-06-03 15:42:37',
            ),
            
        ));        
    }
}


