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
            'address'=>'Jl. Raya Slipi Kemangisan',
            'latitude' => 80.7 ,
            'longitude' => 98.6 ,
            'size'=>'10',
            'resource'=> 168000000,
            'reserves'=> 168000000,
            'contracted_volume'=> 1000000,
            'annual_production' => 1000000,
            'stockpile_distance'=> 100,
            'stripping_ratio' => 10.7 ,
            'road_accessibility' => 'Open Cut' ,
            'port_distance' => 262,
            'road_capacity' => 3000000 ,
            'port_name' => 'Nilau' ,
            'river_capacity' => '' ,
            'license_type' => 'IUP' ,
            'license_expired_date' => '2022-04-05' ,
            'status' => 'a'
        ]);
        
        Concession::create([
            'concession_name'=> 'KIM East 2',
            'owner'=> 'East 2',
            'seller_id' => '1',
            'city'=>'Jakarta',
            'address'=>'Jl. Raya Bekasi',
            'latitude' => 80.7 ,
            'longitude' => 98.6 ,
            'size'=>'10',
            'resource'=> 169000000,
            'reserves'=> 169000000,
            'contracted_volume'=> 2000000,
            'annual_production' => 2000000,
            'stockpile_distance'=> 200,
            'stripping_ratio' => 10.7 ,
            'road_accessibility' => 'Open Cut' ,
            'port_distance' => 300,
            'road_capacity' => 4000000 ,
            'port_name' => 'Nilau' ,
            'river_capacity' => '' ,
            'license_type' => 'IUP' ,
            'license_expired_date' => '2022-04-05' ,
            'status' => 'a'
        ]);

        Concession::create([
            'concession_name'=> 'BIB BS, SS, NSN BLOCK',
            'owner'=> 'East',
            'seller_id' => '1',
            'city'=>'Jakarta',
            'address'=>'Jl. Raya Slipi Kemangisan',
            'latitude' => 80.7 ,
            'longitude' => 98.6 ,
            'size'=>'10',
            'resource'=> 168000000,
            'reserves'=> 168000000,
            'contracted_volume'=> 1000000,
            'annual_production' => 1000000,
            'stockpile_distance'=> 100,
            'stripping_ratio' => 10.7 ,
            'road_accessibility' => 'Open Cut' ,
            'port_distance' => 262,
            'road_capacity' => 3000000 ,
            'port_name' => 'Nilau' ,
            'river_capacity' => '' ,
            'license_type' => 'IUP' ,
            'license_expired_date' => '2022-04-05' ,
            'status' => 'a'
        ]);
        
        
        
    }
}
