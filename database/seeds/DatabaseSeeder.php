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
        $this->call(BuyersTableSeeder::class);
        $this->call(SellersTableSeeder::class);
        $this->call(BuyOrderTableSeeder::class);
        $this->call(SellOrderTableSeeder::class);
        $this->call(VendorsTableSeeder::class);
        $this->call(ConcessionTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ContactTableSeeder::class);
        $this->call(BuyerSellerTableSeeder::class);
        //$this->call(IndexTableSeeder::class);
        $this->call(DealTableSeeder::class);
        $this->call(BuyDealTableSeeder::class);
        $this->call(SellDealTableSeeder::class);
        $this->call(PortTableSeeder::class);

        Model::reguard();
    }
}
