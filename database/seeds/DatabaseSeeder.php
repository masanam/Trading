<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(ConcessionTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(PortTableSeeder::class);
        $this->call(FactoryTableSeeder::class);
        $this->call(IndexTableSeeder::class);
        $this->call(LeadsTableSeeder::class);
        $this->call(ContractsTableSeeder::class);
        $this->call(ShipmentTableSeeder::class);

        Model::reguard();
    }
}
