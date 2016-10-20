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
    	Port::create([
	        'port_name' => 'Nial',
	        'owner' => 'PT. dummy',
	        'is_private' => 1,
	        'location' => 'tanah bumbu',
	        'size' => 1000,
	        'river_capacity' => 10,
	        'latitude' => 81.8,
	        'longitude' => 99.6,
	        'anchorage_distance' => 123,
	        'has_conveyor' => 1,
	        'has_crusher' => 1,
	        'has_blending' => 1,
	        'draft_height' => 15
    	]);
    }
}
