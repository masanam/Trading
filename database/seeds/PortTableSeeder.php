<?php

use Illuminate\Database\Seeder;
use App\Model\Port;

class PortTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $ports = [
        ['id'=>1, 'company' => 4, 'port_name' => 'Jetty Indexim', 'owner' => 'Indexim', 'is_private' => 1, 'location' => 'Kaliorang', 'size' => 0, 'river_capacity' => 0, 'latitude' => 0.8827427, 'longitude' => 117.81001, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 1, 'draft_height' => 222222],
        ['id'=>2, 'company' => 5, 'port_name' => 'Berau Coal, PT', 'owner' => 'Kalimantan Timur', 'is_private' => 1, 'location' => 'Sungai Segah', 'size' => 0, 'river_capacity' => 0, 'latitude' => 2.156904, 'longitude' => 117.4911258, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 0, 'draft_height' => 0],
        ['id'=>3, 'company' => 6, 'port_name' => 'Jetty BIB', 'owner' => 'BIB', 'is_private' => 0, 'location' => 'Bunati', 'size' => 0, 'river_capacity' => 0, 'latitude' => -3.7559161, 'longitude' => 115.6112452, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 1, 'draft_height' => 0],
        ['id'=>4, 'company' => 7, 'port_name' => 'Jetty Jembayan', 'owner' => 'JMB', 'is_private' => 1, 'location' => 'Sungai Mahakam', 'size' => 0, 'river_capacity' => 0, 'latitude' => 1.5408, 'longitude' => 117.1746903, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 1, 'draft_height' => 0]


        // ['seller' => [3,4], 'port_name' => 'Jetty MAS', 'owner' => 'MAS', 'is_private' => 1, 'location' => 'Sungai Segah', 'size' => 0, 'river_capacity' => 0, 'latitude' => 2.156904, 'longitude' => 117.4911258, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 1, 'draft_height' => 0],
        // ['seller' => 5, 'port_name' => 'Jetty BBE', 'owner' => 'BBE', 'is_private' => 1, 'location' => 'Kalimantan Timur', 'size' => 0, 'river_capacity' => 0, 'latitude' => 2.056904, 'longitude' => 118.4911258, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 1, 'draft_height' => 0],
        // ['seller' => 7, 'port_name' => 'Jetty KJB', 'owner' => 'KJB', 'is_private' => 1, 'location' => 'Kalimantan Timur', 'size' => 0, 'river_capacity' => 0, 'latitude' => 1.5408, 'longitude' => 117.1746903, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 1, 'draft_height' => 0],
        // ['seller' => 8, 'port_name' => 'Arutmin', 'owner' => 'Arutmin', 'is_private' => 1, 'location' => 'Satui', 'size' => 0, 'river_capacity' => 0, 'latitude' => -3.6765216, 'longitude' => 115.3087854, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 1, 'draft_height' => 0],
        // ['seller' => 9, 'port_name' => 'Tanah Merah Coal Terminal', 'owner' => 'Kideco Jaya Agung', 'is_private' => 1, 'location' => 'Kalimantan Timur', 'size' => 0, 'river_capacity' => 0, 'latitude' => 1.5408, 'longitude' => 117.1746903, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 0, 'draft_height' => 0],
        // ['seller' => [10,11], 'port_name' => 'Jhonlin Jetty', 'owner' => 'Jhonlin', 'is_private' => 1, 'location' => 'Batulicin', 'size' => 0, 'river_capacity' => 0, 'latitude' => -3.6765216, 'longitude' => 115.3087854, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 1, 'draft_height' => 0],
        // ['seller' => 12, 'port_name' => 'Pulau Baai Port', 'owner' => 'Pelindo', 'is_private' => 0, 'location' => 'Bengkulu', 'size' => 2, 'river_capacity' => 0, 'latitude' => -3.9080967, 'longitude' => 102.302857, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 0, 'draft_height' => 15],
        // ['seller' => 16, 'port_name' => 'Tersus PTBA,Tarahan', 'owner' => 'PT.BA', 'is_private' => 1, 'location' => 'Tarahan', 'size' => 0, 'river_capacity' => 0, 'latitude' => -5.5635298, 'longitude' => 105.3613146, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 0, 'draft_height' => 15],
        // ['seller' => 19, 'port_name' => 'Jetty Pada Idi', 'owner' => 'Pada Idi', 'is_private' => 1, 'location' => 'Luwe', 'size' => 0, 'river_capacity' => 0, 'latitude' => -4.4523772, 'longitude' => 120.3674163, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 1, 'draft_height' => 0],
        // ['seller' => [21,22,23], 'port_name' => 'Jetty SBB', 'owner' => 'Sungai Bakti Berlian', 'is_private' => 1, 'location' => 'Sungai Segah', 'size' => 0, 'river_capacity' => 0, 'latitude' => 2.156904, 'longitude' => 117.4911258, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 1, 'draft_height' => 0],
        // ['buyer'=>1, 'seller' => 24, 'port_name' => 'Pelindo', 'owner' => 'Sumatera Barat', 'is_private' => 0, 'location' => 'Teluk Bayur', 'size' => 0, 'river_capacity' => 0, 'latitude' => -1.0043624, 'longitude' => 100.364059, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 1, 'draft_height' => 0],
        // ['buyer'=>[2,3], 'seller' => 27, 'port_name' => 'Nial', 'owner' => 'PT. dummy', 'is_private' => 1, 'location' => 'tanah bumbu', 'size' => 1000, 'river_capacity' => 10, 'latitude' => 1.8, 'longitude' => 116.6, 'anchorage_distance' => 123, 'has_conveyor' => 1, 'has_crusher' => 1, 'has_blending' => 1, 'draft_height' => 15],
      ];
      
      $faker = Faker\Factory::create(); 

      foreach($ports as $port){
        $model = Port::create([
          'port_name' => $port['port_name'],
          'owner' => $port['owner'],
          'is_private' => $port['is_private'],
          'location' => $port['location'],
          'size' => $port['size'],
          'river_capacity' => $port['river_capacity'],
          'latitude' => $port['latitude'],
          'longitude' => $port['longitude'],
          'anchorage_distance' => $port['anchorage_distance'],
          'has_conveyor' => $port['has_conveyor'],
          'has_crusher' => $port['has_crusher'],
          'has_blending' => $port['has_blending'],
          'draft_height' => $port['draft_height'],
          'daily_discharge_rate' => $faker->numberBetween($min = 1, $max = 55),
          'status' => 'a'
        ]);
        if(isset($port['company'])) $model->companies()->attach($port['company']);
      }
    }
}
