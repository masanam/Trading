<?php

use Illuminate\Database\Seeder;
use App\Model\Product;


class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_name = [
          'Mahoni', 'Mahoni B', 'Agathis', 'Sungkai NS', 'Sungkai LS', 'Sungkai HS', 'Sungkai MS'
        ];

        foreach(range(0,6) as $index)
        {
        	$faker = Faker\Factory::create(); 

          Product::create([
            'concession_id' => $faker->numberBetween($min = 0, $max = 2),
			'product_name' => $product_name[$index],
            'tm_min' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 0.5),
            'tm_max' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.5, $max = 1.5),
            'im_min' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 0.3),
            'im_max' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.3, $max = 0.5),
            'ash_min' => $faker->randomFloat($nbMaxDecimals = 2, $min = 2, $max = 5),
            'ash_max' => $faker->randomFloat($nbMaxDecimals = 2, $min = 5, $max = 7),
            'fc_min' => $faker->randomFloat($nbMaxDecimals = 2, $min = 2, $max = 5),
            'fc_max' => $faker->randomFloat($nbMaxDecimals = 2, $min = 5, $max = 7),
            'vm_min' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 3),
            'vm_max' => $faker->randomFloat($nbMaxDecimals = 2, $min = 3, $max = 5),
            'ts_min' => $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 15),
            'ts_max' => $faker->randomFloat($nbMaxDecimals = 2, $min = 15, $max = 20),
            'ncv_min' => $faker->numberBetween($min = 50, $max = 55)*100,
            'ncv_max' => $faker->numberBetween($min = 55, $max = 60)*100,
            'gcv_arb_min' => $faker->numberBetween($min = 50, $max = 55)*100,
            'gcv_arb_max' => $faker->numberBetween($min = 55, $max = 60)*100,
            'gcv_adb_min' => $faker->numberBetween($min = 50, $max = 55)*100,
            'gcv_adb_max' => $faker->numberBetween($min = 55, $max = 60)*100,
            'hgi_min' => $faker->numberBetween($min = 40, $max = 55),
            'hgi_max' => $faker->numberBetween($min = 55, $max = 70),
            'size_min' => $faker->numberBetween($min = 40, $max = 45),
            'size_max' => $faker->numberBetween($min = 45, $max = 50),
            'fe203_min'=> $faker->numberBetween($min = 45, $max = 50),
            'fe203_max'=> $faker->numberBetween($min = 45, $max = 50),  
            'cvnar_min'=> $faker->numberBetween($min = 45, $max = 50), 
            'cvnar_max'=> $faker->numberBetween($min = 45, $max = 50),
            'aft_min'=> $faker->numberBetween($min = 45, $max = 50), 
            'aft_max'=> $faker->numberBetween($min = 45, $max = 50),
            'status' => 'a'
          ]);
        }
    }
}
