<?php

use App\Model\BuyOrder;

use Illuminate\Database\Seeder;

class BuyOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create();

      BuyOrder::create([
            'user_id' => 1 ,
            'buyer_id' => 1 ,

            'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur',
            'latitude' => '-7.1844498' ,
            'longitude' => '112.6528737' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

            'tm_min' => 12,
            'tm_max' => 18,
            'im_min' => 8,
            'im_max' => 11,
            'ash_min' => 15,
            'ash_max' => 16,
            'fc_min' => 0,
            'fc_max' => 41,
            'vm_min' => 34,
            'vm_max' => 42,
            'ts_min' => 0,
            'ts_max' => 1,
            'ncv_min' => 0,
            'ncv_max' => 0,
            'gcv_arb_min' => 0,
            'gcv_arb_max' => 0,
            'gcv_adb_min' => 6100,
            'gcv_adb_max' => 6300,
            'hgi_min' => 35,
            'hgi_max' => 40,
            'size_min' => 0,
            'size_max' => 50,

            'volume' => 5000,
            'status' => 'o'
      ]);

      BuyOrder::create([
            'user_id' => 1 ,
            'buyer_id' => 1 ,

            'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur',
            'latitude' => '-7.1844498' ,
            'longitude' => '112.6528737' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

            'tm_min' => 6,
            'tm_max' => 11,
            'im_min' => 0,
            'im_max' => 5,
            'ash_min' => 0,
            'ash_max' => 9.87,
            'fc_min' => 0,
            'fc_max' => 40.63,
            'vm_min' => 39,
            'vm_max' => 42,
            'ts_min' => 0.41,
            'ts_max' => 1,
            'ncv_min' => 0,
            'ncv_max' => 0,
            'gcv_arb_min' => 0,
            'gcv_arb_max' => 0,
            'gcv_adb_min' => 5600,
            'gcv_adb_max' => 5800,
            'hgi_min' => 45,
            'hgi_max' => 50,
            'size_min' => 0,
            'size_max' => 200,

            'volume' => 3000,
            'status' => 'p'
      ]);

      BuyOrder::create([
            'user_id' => 2 ,
            'buyer_id' => 1 ,

            'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur',
            'latitude' => '-7.1844498' ,
            'longitude' => '112.6528737' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

            'tm_min' => 5,
            'tm_max' => 8,
            'im_min' => 0,
            'im_max' => 7.5,
            'ash_min' => 0,
            'ash_max' => 10.23,
            'fc_min' => 0,
            'fc_max' => 41,
            'vm_min' => 41,
            'vm_max' => 43,
            'ts_min' => 0.56,
            'ts_max' => 0.87,
            'ncv_min' => 0,
            'ncv_max' => 0,
            'gcv_arb_min' => 0,
            'gcv_arb_max' => 0,
            'gcv_adb_min' => 5300,
            'gcv_adb_max' => 5500,
            'hgi_min' => 45,
            'hgi_max' => 50,
            'size_min' => 0,
            'size_max' => 150,

            'volume' => 2000,
            'status' => 'f'
      ]);

      BuyOrder::create([
            'user_id' => 3 ,
            'buyer_id' => 2 ,

            'address' => 'Jalan Raya Anyer KM 11. Ciwandan Cilegon 42446. Banten' ,
            'latitude' => '-6.02428' ,
            'longitude' => '105.965' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

            'tm_min' => 6,
            'tm_max' => 10,
            'im_min' => 0,
            'im_max' => 5,
            'ash_min' => 0,
            'ash_max' => 11,
            'fc_min' => 0,
            'fc_max' => 42.59,
            'vm_min' => 0,
            'vm_max' => 42,
            'ts_min' => 0,
            'ts_max' => 1.2,
            'ncv_min' => 0,
            'ncv_max' => 0,
            'gcv_arb_min' => 0,
            'gcv_arb_max' => 0,
            'gcv_adb_min' => 5600,
            'gcv_adb_max' => 5800,
            'hgi_min' => 50,
            'hgi_max' => 60,
            'size_min' => 0,
            'size_max' => 50,

            'volume' => 4500,
            'status' => 'p'
      ]);

      BuyOrder::create([
            'user_id' => 1 ,
            'buyer_id' => 3 ,

            'address' => 'Jl. MH Thamrin No. 51, Jakarta 10350' ,
            'latitude' => '-6.2012618' ,
            'longitude' => '106.7861946' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

            'tm_min' => 7,
            'tm_max' => 11,
            'im_min' => 0,
            'im_max' => 5,
            'ash_min' => 0,
            'ash_max' => 10,
            'fc_min' => 0,
            'fc_max' => 41.67,
            'vm_min' => 0,
            'vm_max' => 41,
            'ts_min' => 0,
            'ts_max' => 1,
            'ncv_min' => 0,
            'ncv_max' => 0,
            'gcv_arb_min' => 0,
            'gcv_arb_max' => 0,
            'gcv_adb_min' => 5800,
            'gcv_adb_max' => 6000,
            'hgi_min' => 45,
            'hgi_max' => 50,
            'size_min' => 0,
            'size_max' => 100,

            'volume' => 6000,
            'status' => 'f'
      ]);

      BuyOrder::create([
            'user_id' => 3 ,
            'buyer_id' => 3 ,

            'address' => 'Jl. MH Thamrin No. 51, Jakarta 10350' ,
            'latitude' => '-6.2012618' ,
            'longitude' => '106.7861946' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

            'tm_min' => 5,
            'tm_max' => 10,
            'im_min' => 0,
            'im_max' => 6,
            'ash_min' => 13,
            'ash_max' => 14.55,
            'fc_min' => 0,
            'fc_max' => 41,
            'vm_min' => 0,
            'vm_max' => 38.97,
            'ts_min' => 0,
            'ts_max' => 0.14,
            'ncv_min' => 0,
            'ncv_max' => 0,
            'gcv_arb_min' => 0,
            'gcv_arb_max' => 0,
            'gcv_adb_min' => 5600,
            'gcv_adb_max' => 0,
            'hgi_min' => 50,
            'hgi_max' => 60,
            'size_min' => 0,
            'size_max' => 150,

            'volume' => 1500,
            'status' => 'c'
      ]);
    }
}
