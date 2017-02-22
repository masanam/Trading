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

        if(config('app.deployment') == 'berau' && config('app.env') == 'production') $this->call(ProductionBerauSeeder::class);
        else {
            $this->call(UsersTableSeeder::class);
            $this->call(CompaniesTableSeeder::class);
            $this->call(OrderApprovalSchemesTableSeeder::class);
            $this->call(CountriesTableSeeder::class);
            $this->call(ConcessionTableSeeder::class);
            $this->call(ProductTableSeeder::class);
            $this->call(PortTableSeeder::class);
            $this->call(FactoryTableSeeder::class);
            $this->call(IndexTableSeeder::class);
            $this->call(LeadsTableSeeder::class);
            $this->call(MiningLicenseTableSeeder::class);
            $this->call(SpatialDataTableSeeder::class);
            $this->call(SalesTargetTableSeeder::class);
            $this->call(ContractsTableSeeder::class);
            $this->call(ShipmentTableSeeder::class);
            $this->call(DocumentTableSeeder::class);
        }

        Model::reguard();
    }
}
