<?php

use App\Model\Seller;
use App\Model\User;

use Illuminate\Database\Seeder;

class SellersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seller::create([                
            'company_name' => 'PT Kuansing Inti Makmur',            
            'user_id' => '2',
            'phone' => '+6276132317',
            'is_trade'=>'1',
            'is_affiliated'=>'1',
            'hauling_road'=>'province',
            'remaining_volume'=>'2',
            'license_type'=>'IUP Explorasi',
            'license_expiration_date'=>'2016-10-02',
            'preferred_trading_term'=>'cnf',
            'preferred_payment_term'=>'',
            'purchasing_countries'=>'',
            'email' => 'info@kuansing.com',
            'web' => 'https://www.kim.com',
            'industry' => 'Coal Mining',
            'city' => 'Pekanbaru',
            'address' => 'JL. Jend Sudirman No.9, Tengkerang Sel., Bukit Raya',
            'latitude' => '0.496853',
            'longitude' => '101.4564464',
            'description' => 'PT Kuansing Inti Makmur operates as a coal exploration and mining company. The company is based in Jakarta, Indonesia. PT Kuansing Inti Makmur operates as a subsidiary of PT Dian Swastatika Sentosa Tbk.',
            'status' => 'a'
        ])/*->user()->attach(6)*/;

        Seller::create([                
            'company_name' => 'PT Borneo Indobara',
            'user_id' => '3',
            'is_trade'=>'1',
            'is_affiliated'=>'1',
            'hauling_road'=>'mine',
            'remaining_volume'=>'1',
            'license_type'=>'IUP Produksi',
            'license_expiration_date'=>'2016-10-02',
            'preferred_trading_term'=>'cif',
            'preferred_payment_term'=>'',
            'purchasing_countries'=>'',
            'phone' => '+622131990092',
            'email' => 'info@borneo.com',
            'web' => 'https://www.borneo-indobara.com',
            'industry' => 'Coal Mining',
            'city' => 'Banjarmasin',
            'address' => 'Plaza BII 2 Lt. 7 Jl. M. H. Thamrin No. 51',
            'latitude' => '-6.21539',
            'longitude' => '106.81157',
            'description' => 'In the initial stage, all the coal shipment is conducted at the Muara Satui anchorage point (Lat. 03’56 S / 115’30 E). Transshipment to the main vessel is done using barges from two ports on the banks of Satui River. Loading rate at the anchorage point is over 8,000 MT. Borneo Indobara is currently building a main port facility in the coast of Sebamban, which will enable the company to increase its throughput significantly. This port will be commisioned by the end of 2008.',
            'status' => 'a'
        ])/*->user()->attach(6)*/;

        Seller::create([                
            'company_name' => 'PT Golden Energy Mines',        
            'user_id' => '3',
            'is_trade'=>'1',
            'is_affiliated'=>'1',
            'hauling_road'=>'province',
            'remaining_volume'=>'1',
            'license_type'=>'IUP Produksi',
            'license_expiration_date'=>'2016-10-02',
            'preferred_trading_term'=>'pas',
            'preferred_payment_term'=>'',
            'purchasing_countries'=>'',
            'phone' => '+622150186888',
            'email' => 'info@.com',
            'web' => 'https://www..com',
            'industry' => 'Coal Mining',
            'city' => 'Jakarta',
            'address' => 'Lantai 7, Sinarmas Land Plaza Tower 2, Jl. M.H. Thamrin No.51, RT.9/RW.4, Gondangdia, Menteng',
            'latitude' => '-6.1901426',
            'longitude' => '106.8231203',
            'description' => 'Golden Energy Mines is the coal mining group of Sinarmas. We operate in three areas: South Kalimantan, Central Kalimantan, and South Sumatera, Jambi. The Company has resources as much as 1.93 billion tons of thermal coal and coal reserves of about 849 million tons; which provides promising prospects for growth in operations and financial performance in the future for a long period.',
            'status' => 'a'
        ])/*->user()->attach(6);*/;
    }
}
