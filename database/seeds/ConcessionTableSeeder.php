<?php

use Illuminate\Database\Seeder;
use App\Model\Concession;

class ConcessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create(); 

        Concession::create([
            'concession_name'=> 'KIM East',
            'owner'=> 'East',
        	'seller_id' => '1',
            'city'=>'Jakarta',
            'country' => 'ID',
            'polygon' => '',
            'address'=>'Jl. Raya Slipi Kemangisan',
            'latitude' => 80.7 ,
            'longitude' => 98.6 ,
            'size'=>'10',
            'resource'=> 1680,
            'reserves'=> 1680,
            'remaining_volume' => 1000,
            'contracted_volume'=> 10,
            'annual_production' => 10,
            'stockpile_distance'=> 100,
            'stripping_ratio' => 10.7 ,
            'road_accessibility' => 'Open Cut' ,
            'port_distance' => 262,
            'road_capacity' => 30 ,
            // 'port_name' => 'Nilau' ,
            // 'river_capacity' => '' ,
            'license_type' => 'IUP' ,
            'license_expiry_date' => '2022-04-05' ,
            'status' => 'a'
        ]);
        
        Concession::create([
            'concession_name'=> 'KIM East 2',
            'owner'=> 'East 2',
            'seller_id' => '1',
            'city'=>'Jakarta',
            'country' => 'ID',
            'polygon' => '',
            'address'=>'Jl. Raya Bekasi',
            'latitude' => 80.7 ,
            'longitude' => 98.6 ,
            'size'=>'10',
            'resource'=> 1690,
            'reserves'=> 1690,
            'remaining_volume' => 1000,
            'contracted_volume'=> 20,
            'annual_production' => 20,
            'stockpile_distance'=> 200,
            'stripping_ratio' => 10.7 ,
            'road_accessibility' => 'Open Cut' ,
            'port_distance' => 300,
            'road_capacity' => 40 ,
            // 'port_name' => 'Nilau' ,
            // 'river_capacity' => '' ,
            'license_type' => 'IUP' ,
            'license_expiry_date' => '2022-04-05' ,
            'status' => 'a'
        ]);

        Concession::create([
            'concession_name'=> 'BIB BS, SS, NSN BLOCK',
            'owner'=> 'East',
            'seller_id' => '1',
            'city'=>'Jakarta',
            'country' => 'ID',
            'polygon' => '',
            'address'=>'Jl. Raya Slipi Kemangisan',
            'latitude' => 80.7 ,
            'longitude' => 98.6 ,
            'size'=>'10',
            'resource'=> 1680,
            'reserves'=> 1680,
            'remaining_volume' => 1000,
            'contracted_volume'=> 10,
            'annual_production' => 10,
            'stockpile_distance'=> 100,
            'stripping_ratio' => 10.7 ,
            'road_accessibility' => 'Open Cut' ,
            'port_distance' => 262,
            'road_capacity' => 30 ,
            // 'port_name' => 'Nilau' ,
            // 'river_capacity' => '' ,
            'license_type' => 'IUP' ,
            'license_expiry_date' => '2022-04-05' ,
            'status' => 'a'
        ]);
        
        
        
    }
}
