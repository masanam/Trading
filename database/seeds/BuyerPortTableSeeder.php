<?php

use Illuminate\Database\Seeder;
use App\Model\BuyerPort;

class BuyerPortTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuyerPort::create([
            'buyer_id' => '1' ,
            'port_id' => '2' ,
            'distance' => '123' ,
            'status' => 'a' 
        ]) ;
    }
}
