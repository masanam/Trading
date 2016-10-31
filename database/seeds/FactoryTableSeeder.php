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
        'factory_name' => 'PT Faktor' ,
        'buyer_id' => 1 ,
        'owner' => 'Mr Nice Guy' ,
        'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur',
        'city'=> 'Jawa Timur',
        'country'=>'INA',
        'latitude' => '-7.1844498' ,
        'longitude' => '112.6528737' ,
        'size' => $faker->numberBetween($min = 1, $max = 2000),
        'consumption' => $faker->numberBetween($min = 1, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);
    }
}
