<?php

use App\Model\User;
use App\Model\Buyer;

use Illuminate\Database\Seeder;

class BuyersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Buyer::create([
            'id' => '1' ,
            'user_id' => '2' ,
            'company_name' => 'PT.Wilmar Nabati Indonesia' ,
            'country'=> 'INA',
            'is_trader'=>'1',
            'is_affiliated'=>'1',
            'phone' => '(031) 3979414' ,
            'email' => 'info@wilmar-international.com' ,
            'web' => 'www.wilmar-international.com' ,
            'industry' => 'Palm Oil Manufacturer' ,
            'annual_demand'=>'16800000',
            'preferred_trading_term'=>'cnf',
            'preferred_payment_term'=>'fob',
            'city' => 'Gresik' ,
            'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur' ,
            'latitude' => '-7.1844498' ,
            'longitude' => '112.6528737' ,
            'description' => 'This is an palm oil company' ,
            'status' => 'a' 
        ]) ;

        Buyer::create([
            'id' => '2' ,
            'user_id' => '1' ,
            'company_name' => 'PT.SMART Dumai' ,
            'country'=> 'INA',
            'is_trader'=>'1',
            'is_affiliated'=>'1',
            'phone' => '(031) 3979414' ,
            'email' => 'info@wilmar-international.com' ,
            'web' => 'www.wilmar-international.com' ,
            'industry' => 'Palm Oil Manufacturer' ,
            'annual_demand'=>'16800000',
            'preferred_trading_term'=>'cnf',
            'preferred_payment_term'=>'fob',
            'city' => 'Gresik' ,
            'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur' ,
            'latitude' => '-7.1844498' ,
            'longitude' => '112.6528737' ,
            'description' => 'This is an palm oil company' ,
            'status' => 'a' 
        ]) ;


        Buyer::create([
            'id' => '3' ,
            'user_id' => '1' ,
            'company_name' => 'PT.SMART' ,
            'country'=> 'INA',
            'is_trader'=>'1',
            'is_affiliated'=>'1',
            'phone' => '(031) 3979414' ,
            'email' => 'info@wilmar-international.com' ,
            'web' => 'www.wilmar-international.com' ,
            'industry' => 'Palm Oil Manufacturer' ,
            'annual_demand'=>'16800000',
            'preferred_trading_term'=>'cnf',
            'preferred_payment_term'=>'fob',
            'city' => 'Gresik' ,
            'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur' ,
            'latitude' => '-7.1844498' ,
            'longitude' => '112.6528737' ,
            'description' => 'This is an palm oil company' ,
            'status' => 'a' 
        ]) ;
    }
}
