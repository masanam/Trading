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
        'company_id' => 1 ,
        'owner' => 'PT.Wilmar Nabati Indonesia' ,
        'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur',
        'city'=> 'Jawa Timur',
        'country'=>'ID',
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
        'company_id' => 2 ,
        'owner' => 'PT SMART' ,
        'address' => 'Jl. Rungkut Industri X No.6, Rungkut Tengah, Gn. Anyar, Kota SBY, Jawa Timur 60293',
        'city'=> 'Jawa Timur',
        'country'=>'ID',
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
        'company_id' => 2 ,
        'owner' => 'PT SMART' ,
        'address' => 'Jl. Datuk Laksamana, Kota Dumai, Riau 28811',
        'city'=> 'Dumai',
        'country'=>'ID',
        'latitude' => 1.6628219,
        'longitude' => 101.4438486,
        'size' => $faker->numberBetween($min = 100, $max = 2000),
        'consumption' => $faker->numberBetween($min = 100, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);

        Factory::create([
        'factory_name' => 'Jetty MAS' ,
        'company_id' => 2 ,
        'owner' => 'MAS' ,
        'address' => 'Jl. Datuk Laksamana, Kota Dumai, Riau 28811',
        'city'=> 'Sungai Segah',
        'country'=>'ID',
        'latitude' => 2.156904,
        'longitude' => 117.4911258,
        'size' => $faker->numberBetween($min = 100, $max = 2000),
        'consumption' => $faker->numberBetween($min = 100, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);

        Factory::create([
        'factory_name' => 'Arutmin' ,
        'company_id' => 2 ,
        'owner' => 'Arutimin' ,
        'address' => '',
        'city'=> 'Kalimantan Timur',
        'country'=>'ID',
        'latitude' => 1.6628219,
        'longitude' => 101.4438486,
        'size' => $faker->numberBetween($min = 100, $max = 2000),
        'consumption' => $faker->numberBetween($min = 100, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);

        Factory::create([
        'factory_name' => 'Jetty BBE' ,
        'company_id' => 2 ,
        'owner' => 'BBE' ,
        'address' => '',
        'city'=> 'Kalimantan Timur',
        'country'=>'ID',
        'latitude' => 2.056904,
        'longitude' => 118.4911258,
        'size' => $faker->numberBetween($min = 100, $max = 2000),
        'consumption' => $faker->numberBetween($min = 100, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);

        Factory::create([
        'factory_name' => 'Jetty KJB' ,
        'company_id' => 2 ,
        'owner' => 'KJB' ,
        'address' => '',
        'city'=> 'Kalimantan Timur',
        'country'=>'ID',
        'latitude' => 1.5408,
        'longitude' => 117.1746903,
        'size' => $faker->numberBetween($min = 100, $max = 2000),
        'consumption' => $faker->numberBetween($min = 100, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);

        Factory::create([
        'factory_name' => 'Pulau Baai Port' ,
        'company_id' => 2 ,
        'owner' => 'Pelindo' ,
        'address' => 'Bengkulu',
        'city'=> 'Bengkulu',
        'country'=>'ID',
        'latitude' => -3.9080967,
        'longitude' => 102.302857,
        'size' => $faker->numberBetween($min = 100, $max = 2000),
        'consumption' => $faker->numberBetween($min = 100, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);

        Factory::create([
        'factory_name' => 'Tersus PTBA,Tarahan' ,
        'company_id' => 2 ,
        'owner' => 'PT.BA' ,
        'address' => 'Tarahan',
        'city'=> 'Tarahan',
        'country'=>'ID',
        'latitude' => -5.5635298,
        'longitude' => 105.3613146,
        'size' => $faker->numberBetween($min = 100, $max = 2000),
        'consumption' => $faker->numberBetween($min = 100, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);

        Factory::create([
        'factory_name' => 'Jetty SBB' ,
        'company_id' => 2 ,
        'owner' => 'Sungai Bakti Berlian' ,
        'address' => 'Sungai Segah',
        'city'=> 'Sungai Segah',
        'country'=>'ID',
        'latitude' => -5.5635298,
        'longitude' => 105.3613146,
        'size' => $faker->numberBetween($min = 100, $max = 2000),
        'consumption' => $faker->numberBetween($min = 100, $max = 2000),
        'port_id'=>'1',
        'port_distance'=>200,
        'status' => 'a'
      ]);
    }
}
