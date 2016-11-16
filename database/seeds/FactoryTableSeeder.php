<?php

use App\Model\Factory;
use Illuminate\Database\Seeder;

class FactoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$faker = Faker\Factory::create();

      Factory::create([
        'factory_name' => 'PT.Wilmar Nabati Indonesia' ,
        'buyer_id' => 1 ,
        'owner' => 'PT.Wilmar Nabati Indonesia' ,
        'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur',
        'city'=> 'Jawa Timur',
        'country'=>'INA',
        'latitude' => '-7.1844498' ,
        'longitude' => '112.6528737' ,
        'size' => $faker->numberBetween($min = 100, $max = 2000),
        'consumption' => $faker->numberBetween($min = 100, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);

      Factory::create([
        'factory_name' => 'PT. SMART Jatim' ,
        'buyer_id' => 2 ,
        'owner' => 'PT SMART' ,
        'address' => 'Jl. Rungkut Industri X No.6, Rungkut Tengah, Gn. Anyar, Kota SBY, Jawa Timur 60293',
        'city'=> 'Jawa Timur',
        'country'=>'INA',
        'latitude' => -7.3348969,
        'longitude' => 112.7646939,
        'size' => $faker->numberBetween($min = 100, $max = 2000),
        'consumption' => $faker->numberBetween($min = 100, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);

    	Factory::create([
        'factory_name' => 'PT. SMART Dumai' ,
        'buyer_id' => 2 ,
        'owner' => 'PT SMART' ,
        'address' => 'Jl. Datuk Laksamana, Kota Dumai, Riau 28811',
        'city'=> 'Dumai',
        'country'=>'INA',
        'latitude' => 1.6628219,
        'longitude' => 101.4438486,
        'size' => $faker->numberBetween($min = 100, $max = 2000),
        'consumption' => $faker->numberBetween($min = 100, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);
    }
}
