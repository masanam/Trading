<?php 

use App\Model\Tonnage;
use App\Model\TonnageHistory;

use Illuminate\Database\Seeder;

class TonnagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tonnage::create([
	    	'id' => 1,
	    	'product_id' => '1' ,
	    	'month' => '2' ,
	    	'year'=>'2017',
	    	'value' => '20000' ,
	    	'status' => 'a' 
        ]) ;
        Tonnage::create([
	    	'id' => 2,
	    	'product_id' => '2' ,
	    	'month' => '1' ,
	    	'year'=>'2017',
	    	'value' => '31142' ,
	    	'status' => 'a' 
        ]) ;
        Tonnage::create([
	    	'id' => 3,
	    	'product_id' => '1' ,
	    	'month' => '1' ,
	    	'year'=>'2017',
	    	'value' => '23142' ,
	    	'status' => 'a' 
        ]) ;
    }
}
