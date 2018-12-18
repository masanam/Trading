<?php

use App\Model\ProductVariant;

use Illuminate\Database\Seeder;

class ProductVariantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	ProductVariant::create([	    	
	    	'produt_id' => '2' ,
	    	'name_product_variant' => null ,
	    	'status'=>'a'
        ]) ;
        ProductVariant::create([	    	
	    	'produt_id' => '2' ,
	    	'name_product_variant' => 'A' ,
	    	'status'=>'a'
        ]) ;
        ProductVariant::create([
	    	'produt_id' => '2' ,
	    	'name_product_variant' => 'B' ,
	    	'status'=>'a'
        ]) ;
        ProductVariant::create([
	    	'produt_id' => '3' ,
	    	'name_product_variant' => null ,
	    	'status'=>'a'
        ]) ;
    }
}
