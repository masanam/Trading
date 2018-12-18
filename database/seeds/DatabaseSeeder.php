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

        // models that is not bounded by conditions
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrencySeeder::class);

        if(config('app.deployment') == 'berau' && config('app.env') == 'production'){
            $this->call(ProductionBerauSeeder::class);
        } else {
            $this->call(UsersTableSeeder::class);
            $this->call(CompaniesTableSeeder::class);
            $this->call(OrderApprovalSchemesTableSeeder::class);
            $this->call(ConcessionTableSeeder::class);
            $this->call(ProductTableSeeder::class);
            $this->call(PortTableSeeder::class);
            $this->call(FactoryTableSeeder::class);
            $this->call(IndexTableSeeder::class);
            $this->call(LeadsTableSeeder::class);
            $this->call(MiningLicenseTableSeeder::class);
            $this->call(SpatialDataTableSeeder::class);
            $this->call(SalesTargetTableSeeder::class);

            // Created By : Martin
            // Tanggal : 27 Maret 2017

            $this->call(ProductionPlanTableSeeder::class);

            $this->call(ContractsTableSeeder::class);
            $this->call(ShipmentTableSeeder::class);
            $this->call(ShipmentPlanTableSeeder::class);
            $this->call(DocumentTableSeeder::class);
            $this->call(CostsTableSeeder::class);
            $this->call(ProductPricesTableSeeder::class);
            $this->call(StandardSpecificationsTableSeeder::class);
            $this->call(OperationalPricesSettingTableSeeder::class);

            // Created By : Aryo
            // Tanggal : 7 April 2017

            $this->call(InvoiceTableSeeder::class);

            // Created By : Hasapu
            // Tanggal : 21 April 2017

            $this->call(ContractCalculationTableSeeder::class);

            // Create By : Syandi 
            // Tanggal : 2 Mei 2017

            $this->call(LoaderTableSeeder::class);
            



        }

        Model::reguard();
    }
}
