<?php

use Illuminate\Database\Seeder;

use App\Model\StandardSpecification;

class StandardSpecificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StandardSpecification::create([	 
        	'id' => 1,
        	'caloric_value' => 6323,
        	'total_moisture' => 10,
        	'total_sulphur' => 5,
        	'ash' => '12'
        ]) ;
    }
}
