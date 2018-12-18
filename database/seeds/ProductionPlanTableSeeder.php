<?php

// Created By : Martin
// Tanggal : 27 Maret 2017

use App\Model\ProductionPlan;

use Illuminate\Database\Seeder;

class ProductionPlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductionPlan::create([
	    	'product_variant_id' => '1' ,
	    	'month' => '2' ,
	    	'year'=>'2017',
	    	'tonnage' => '25000' ,
	    	'price' => '50000' ,
	    	'status' => 'a'
        ]) ;
        ProductionPlan::create([
	    	'product_variant_id' => '2' ,
	    	'month' => '1' ,
	    	'year'=>'2017',
	    	'tonnage' => '15023' ,
	    	'price' => '31142' ,
	    	'status' => 'a'
        ]) ;
        ProductionPlan::create([
	    	'product_variant_id' => '1' ,
	    	'month' => '1' ,
	    	'year'=>'2017',
	    	'tonnage' => '10200' ,
	    	'price' => '23142' ,
	    	'status' => 'a'
        ]) ;
    }
}
