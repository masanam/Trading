<?php

use App\Model\SalesTarget;

use Illuminate\Database\Seeder;

class SalesTargetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalesTarget::create([
	    	'product_variant_id' => '1' ,
	    	'month' => '2' ,
	    	'year'=>'2017',
	    	'tonnage' => '25000' ,
	    	'price' => '50000' ,
	    	'status' => 'a'
        ]) ;
        SalesTarget::create([
	    	'product_variant_id' => '2' ,
	    	'month' => '1' ,
	    	'year'=>'2017',
	    	'tonnage' => '15023' ,
	    	'price' => '31142' ,
	    	'status' => 'a'
        ]) ;
        SalesTarget::create([
	    	'product_variant_id' => '1' ,
	    	'month' => '1' ,
	    	'year'=>'2017',
	    	'tonnage' => '10200' ,
	    	'price' => '23142' ,
	    	'status' => 'a'
        ]) ;
    }
}
