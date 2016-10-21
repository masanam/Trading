<?php

use App\Model\User;
use App\Model\BuyerSeller;

use Illuminate\Database\Seeder;

class BuyerSellerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuyerSeller::create([
            'id' => '1' ,
            'seller_id' => '1' ,
            'buyer_id' => '2' ,
            'notes' => '' ,
            'is_facilitated' => true ,
            'status' => 'a' 
        ]);

        BuyerSeller::create([
            'id' => '2' ,
            'seller_id' => '1' ,
            'buyer_id' => '1' ,
            'notes' => '' ,
            'is_facilitated' => true ,
            'status' => 'a' 
        ]);
    }
}
