<?php

use Illuminate\Database\Seeder;
use App\Model\Mine;

class MineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create(); 

        Mine::create([
        	'seller_id' => '1',
        
            'latitude' => 80.7 ,
            'longitude' => 98.6 ,

            'mine_name' => 'KIM East',

            'mineable_reserve' => 168000000 ,
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
        
        Mine::create([
        	'seller_id' => '1',
        
            'latitude' => 80.2 ,
            'longitude' => 98.4 ,

            'mine_name' => 'KIM West',

            'mineable_reserve' => 91000000 ,
            'stripping_ratio' => 10.7 ,
            
            'road_accessibility' => 'Open Cut' ,
            'port_distance' => 262,
            'road_capacity' => 3000000 ,
            'port_name' => 'Nilau' ,
            'river_capacity' => '' ,

            'license_type' => 'IUP' ,
            'license_expired_date' => '2018-04-23' ,
            
            'status' => 'a'
        ]);

        Mine::create([
        	'seller_id' => '2',
        
            'latitude' => 34.2 ,
            'longitude' => 97.3 ,

            'mine_name' => 'BIB KG BLOCK',

            'mineable_reserve' => 325000000 ,
            'stripping_ratio' => 4.2 ,
            
            'road_accessibility' => 'Open Cut' ,
            'port_distance' => 0.3,
            'road_capacity' => 40000000 ,
            'port_name' => 'Bunati' ,
            'river_capacity' => 'Open Sea' ,

            'license_type' => 'PKP2B Gen. 2' ,
            'license_expired_date' => '2036-02-17' ,
            
            'status' => 'a'
        ]);
        
        
        Mine::create([
        	'seller_id' => '2',
        
            'latitude' => 34.9 ,
            'longitude' => 95.9 ,

            'mine_name' => 'BIB BS, SS, NSN BLOCK',

            'mineable_reserve' => 19000000 ,
            'stripping_ratio' => 6.4 ,
            
            'road_accessibility' => 'Open Cut' ,
            'port_distance' => 0.3,
            'road_capacity' => 40000000 ,
            'port_name' => 'Bunati' ,
            'river_capacity' => 'Open Sea' ,

            'license_type' => 'PKP2B Gen. 2' ,
            'license_expired_date' => '2036-02-17' ,
            
            'status' => 'a'
        ]);
        
        Mine::create([
        	'seller_id' => '2',
        
            'latitude' => 33.8 ,
            'longitude' => 96.1 ,

            'mine_name' => 'PP BLOCK',

            'mineable_reserve' => 10000000 ,
            'stripping_ratio' => 20.3 ,
            
            'road_accessibility' => 'Open Cut' ,
            'port_distance' => 0.3,
            'road_capacity' => 40000000 ,
            'port_name' => 'Bunati' ,
            'river_capacity' => 'Open Sea' ,

            'license_type' => 'PKP2B Gen. 2' ,
            'license_expired_date' => '2036-02-17' ,
            
            'status' => 'a'
        ]);
    }
}
