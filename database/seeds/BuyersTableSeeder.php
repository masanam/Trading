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
            'trader_id' => '2' ,
            'company_name' => 'PT.Wilmar Nabati Indonesia' ,
            'phone' => '(031) 3979414' ,
            'email' => 'info@wilmar-international.com' ,
            'web' => 'www.wilmar-international.com' ,
            'industry' => 'Palm Oil Manufacturer' ,
            'city' => 'Gresik' ,
            'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur' ,
            'latitude' => '-7.1844498' ,
            'longitude' => '112.6528737' ,
            'description' => 'This is an palm oil company' ,
            'status' => 'a' 
        ]) /*->user()->attach(2)*/;

        Buyer::create([
            'id' => '2' ,
            'trader_id' => '3' ,
            'company_name' => 'Jawa Manis Rafinasi' ,
            'phone' => '(0254) 605520' ,
            'email' => 'info@jawamanis.com' ,
            'web' => 'www.jawamanis.com' ,
            'industry' => 'Sugar Manufacturer' ,
            'city' => 'Cilegon' ,
            'address' => 'Jalan Raya Anyer KM 11. Ciwandan Cilegon 42446. Banten' ,
            'latitude' => '-6.02428' ,
            'longitude' => '105.965' ,
            'description' => 'This is a sugar manufacturing company' ,
            'status' => 'a' 
        ])/*->user()->attach(3)*/;

        Buyer::create([
            'id' => '3' ,
            'trader_id' => '3' ,
            'company_name' => 'PT. SMART Dumai' ,
            'phone' => '+622150338899' ,
            'email' => 'investor@smart-tbk.com' ,
            'web' => 'http://www.smart-tbk.com/' ,
            'industry' => 'Consumption Oil Manufacturer' ,
            'city' => 'Jakarta' ,
            'address' => 'Jl. MH Thamrin No. 51, Jakarta 10350' ,
            'latitude' => '-6.2012618' ,
            'longitude' => '106.7861946' ,
            'description' => 'This is a consumer oil company' ,
            'status' => 'a' 
        ])/*->user()->attach(3)*/;
    }
}
