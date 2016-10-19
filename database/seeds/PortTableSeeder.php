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
    		'id' => 1,
	        'port_name' => 'Nial',
	        'owner' => 'PT. dummy',
	        'is_private' => true,
	        'location' => 'tanah bumbu',
	        'size' => 1000,
	        'river_capacity' => 10,
	        'latitude' => 81.8,
	        'longitude' => 99.6,
	        'anchorage_distance' => 123,
	        'has_conveyor' => true,
	        'has_crusher' => true,
	        'has_blending' => true,
	        'draft_height' => 15,
    	]);
    }
}
