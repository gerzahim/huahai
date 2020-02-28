<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
        $this->call(LocalesTableSeeder::class);
        $this->call(LtmTranslationsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(TransactionTypesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ContactTypesTableSeeder::class);
        $this->call(CouriersTableSeeder::class);
        
        
    }
}
