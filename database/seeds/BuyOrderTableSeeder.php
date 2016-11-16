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
            'user_id' => 7 ,
            'buyer_id' => 1 ,

            'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur',
            'latitude' => '-7.1844498' ,
            'longitude' => '112.6528737' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'order_deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

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
            'max_price' => 5000,
            'ready_date'=>$faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'expired_date'=>$faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'penalty_desc' => 'penalty',

            'volume' => 5000,
            'max_price' => 5000,
            'city'=> 'Jawa Timur',
            'country'=>'INA',
            'port_distance'=>200,
            'port_id'=>'1',
            'port_name'=>'Jetty Indexim',
            'port_status'=>'a',
            'port_daily_rate'=>'11111',
            'port_draft_height'=>'222222',
            'port_latitude'=>'0.8827427',
            'port_longitude'=>'117.81001',
            'product_name'=>'Mahoni B',
            'trading_term'=>'cnf',
            'payment_terms'=>'fob',
            'commercial_term'=>'',
            'order_status' => 'v'
      ]);

      BuyOrder::create([
            'user_id' => 8 ,
            'buyer_id' => 1 ,

            'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur',
            'latitude' => '-7.1844498' ,
            'longitude' => '112.6528737' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'order_deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

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
            'max_price' => 5000,
            'trading_term'=>'',
            'payment_terms'=>'',
            'commercial_term'=>'',
             'ready_date'=>$faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'expired_date'=>$faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),
            'penalty_desc' => 'penalty',
            'commercial_term' => 'commercial_term',

            'volume' => 3000,

            'max_price' => 3000,
            'city'=> 'Jawa Timur',
            'country'=>'INA',
            'port_id'=>'1',
            'port_name'=>'',
            'port_status'=>'',
            'port_daily_rate'=>'1222222',
            'port_draft_height'=>'212133',
            'port_latitude'=>'-7.1844498',
            'port_longitude'=>'112.6528737',
            'product_name'=>'',
            'order_status' => 's'
      ]);

      BuyOrder::create([
            'user_id' => 7 ,
            'buyer_id' => 1 ,

            'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur',
            'latitude' => '-7.1844498' ,
            'longitude' => '112.6528737' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'order_deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

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
            'max_price' => 5000,
            'trading_term'=>'',
            'payment_terms'=>'',
            'commercial_term'=>'',
            'ready_date'=>$faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'expired_date'=>$faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),
            'penalty_desc' => 'penalty',
            'commercial_term' => 'commercial_term',

            'volume' => 2000,

            'max_price' => 2000,
            'city'=> 'Jawa Timur',
            'country'=>'INA',
            'port_id'=>'1',
            'port_name'=>'',
            'port_status'=>'',
            'port_daily_rate'=>'1222222',
            'port_draft_height'=>'212133',
            'port_latitude'=>'-7.1844498',
            'port_longitude'=>'112.6528737',
            'product_name'=>'',
            'order_status' => 'v'
      ]);

      BuyOrder::create([
            'user_id' => 8 ,
            'buyer_id' => 2 ,

            'address' => 'Jalan Raya Anyer KM 11. Ciwandan Cilegon 42446. Banten' ,
            'latitude' => '-6.02428' ,
            'longitude' => '105.965' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'order_deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

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
            'max_price' => 5000,
            'city'=> 'Jawa Timur',
            'country'=>'INA',
            'port_id'=>'1',
            'port_name'=>'',
            'port_status'=>'',
            'port_daily_rate'=>'1222222',
            'port_draft_height'=>'212133',
            'port_latitude'=>'-7.1844498',
            'port_longitude'=>'112.6528737',
            'product_name'=>'',
            'trading_term'=>'',
            'payment_terms'=>'',
            'commercial_term'=>'',
            'ready_date'=>$faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'expired_date'=>$faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

            'penalty_desc' => 'penalty',
            'commercial_term' => 'commercial_term',

            'volume' => 4500,
            'order_status' => 's',

            'port_id' => $faker->numberBetween($min = 1, $max = 3)
      ]);

      BuyOrder::create([
            'user_id' => 8 ,
            'buyer_id' => 3 ,

            'address' => 'Jl. MH Thamrin No. 51, Jakarta 10350' ,
            'latitude' => '-6.2012618' ,
            'longitude' => '106.7861946' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'order_deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

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
            'max_price' => 5000,
            'city'=> 'Jawa Timur',
            'country'=>'INA',
            'port_id'=>'1',
            'port_name'=>'',
            'port_status'=>'',
            'port_daily_rate'=>'1222222',
            'port_draft_height'=>'212133',
            'port_latitude'=>'-7.1844498',
            'port_longitude'=>'112.6528737',
            'product_name'=>'',
            'trading_term'=>'',
            'payment_terms'=>'',
            'commercial_term'=>'',
            'ready_date'=>$faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'expired_date'=>$faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

            'penalty_desc' => 'penalty',
            'commercial_term' => 'commercial_term',

            'volume' => 6000,
            'order_status' => 'v',

            'port_id' => $faker->numberBetween($min = 1, $max = 3)
      ]);

      BuyOrder::create([
            'user_id' => 8 ,
            'buyer_id' => 3 ,

            'address' => 'Jl. MH Thamrin No. 51, Jakarta 10350' ,
            'latitude' => '-6.2012618' ,
            'longitude' => '106.7861946' ,

            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'order_deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

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
            'max_price' => 5000,
            'trading_term'=>'',
            'payment_terms'=>'',
            'commercial_term'=>'',
            'ready_date'=>$faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'expired_date'=>$faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

            'penalty_desc' => 'penalty',
            'commercial_term' => 'commercial_term',

            'volume' => 1500,

            'max_price' => 1500,
            'city'=> 'Jawa Timur',
            'country'=>'INA',
            'port_id'=>'1',
            'port_name'=>'',
            'port_status'=>'',
            'port_daily_rate'=>'1222222',
            'port_draft_height'=>'212133',
            'port_latitude'=>'-7.1844498',
            'port_longitude'=>'112.6528737',
            'product_name'=>'',
            'order_status' => 'v'
      ]);

      $address = array([
            'address' => 'Midplaza II 3rd Floor, JL. Jendral Sudirman Kavling 10-11, Jakarta, 10220' ,
            'latitude' => '-6.208779' ,
            'longitude' => '106.8178313' 
      ],
      [
            'address' => 'Jl. Jendral Sudirman Kav 10-11 Karet Tengsin Tanah Abang Jakarta Pusat DKI Jakarta, Karet Tengsin, Tanah Abang, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10220' ,
            'latitude' => '-6.2087789' ,
            'longitude' => '106.8112652' 
      ],
      [
            'address' => 'The Plaza, Jl. M.H. Thamrin No.28-30, RT.9/RW.5, Gondangdia, Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10350' ,
            'latitude' => '-6.1928712' ,
            'longitude' => '106.8199982' 
      ],
      [
            'address' => 'Jl. HR Rasuna Said Kav 1-2 Blok X-1 Kuningan Timur Setiabudi Jakarta Selatan DKI Jakarta, Kuningan Tim., Setia Budi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta' ,
            'latitude' => '-6.19287' ,
            'longitude' => '106.7871672' 
      ],
      [
            'address' => 'Bakrie Tower Lantai 15 Komplek Rasuna Epicentrum, Jl. HR Rasuna Said, Karet Kuningan, Kecamatan Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12940' ,
            'latitude' => '-6.2190898' ,
            'longitude' => '106.8322925' 
      ]);
      
      foreach ($address as $address) {
          BuyOrder::create(array_merge($address, [
            'user_id' => $faker->numberBetween($min = 1, $max = 3) ,
            'buyer_id' => $faker->numberBetween($min = 1, $max = 3) ,


            'order_date' => $faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'order_deadline' => $faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

            'tm_min' => $faker->numberBetween($min = 1, $max = 5) ,
            'tm_max' => $faker->numberBetween($min = 6, $max = 10),
            'im_min' => $faker->numberBetween($min = 1, $max = 5) ,
            'im_max' => $faker->numberBetween($min = 6, $max = 10),
            'ash_min' => $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 15),
            'ash_max' => $faker->randomFloat($nbMaxDecimals = 2, $min = 15, $max = 25),
            'fc_min' => $faker->numberBetween($min = 0, $max = 22),
            'fc_max' => $faker->numberBetween($min = 23, $max = 44),
            'vm_min' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 15),
            'vm_max' => $faker->randomFloat($nbMaxDecimals = 2, $min = 20, $max = 45),
            'ts_min' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1),
            'ts_max' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1.1, $max = 2),
            'ncv_min' => $faker->numberBetween($min = 0, $max = 3),
            'ncv_max' => $faker->numberBetween($min = 4, $max = 6),
            'gcv_arb_min' => $faker->numberBetween($min = 0, $max = 50),
            'gcv_arb_max' => $faker->numberBetween($min = 100, $max = 250),
            'gcv_adb_min' => $faker->numberBetween($min = 0, $max = 50),
            'gcv_adb_max' => $faker->numberBetween($min = 110, $max = 250),
            'hgi_min' => $faker->numberBetween($min = 0, $max = 50),
            'hgi_max' => $faker->numberBetween($min = 60, $max = 100),
            'size_min' => $faker->numberBetween($min = 0, $max = 75),
            'size_max' => $faker->numberBetween($min = 150, $max = 220),
            'max_price' => $faker->numberBetween($min = 1, $max = 500),
            'city'=> 'Jawa Timur',
            'country'=>'INA',
            'port_id'=>'1',
            'port_name'=>'',
            'port_status'=>'',
            'port_daily_rate'=>'1222222',
            'port_draft_height'=>'212133',
            'port_latitude'=>'-7.1844498',
            'port_longitude'=>'112.6528737',
            'product_name'=>$faker->firstName,
            'typical_quality'=>$faker->firstName,
            'trading_term'=>$faker->randomElement($array = array ('CNF','CIF','FAS','FOB','Franco')),
            'payment_terms'=>'TT',
            'commercial_term'=>'',

            'penalty_desc' => 'penalty',

            'ready_date'=>$faker->dateTimeBetween($startDate = "-2 days", $endDate = "now")->format('Y-m-d'),
            'expired_date'=>$faker->dateTimeBetween($startDate = "5 days", $endDate = "10 days")->format('Y-m-d'),

            'volume' => $faker->numberBetween($min = 1000, $max = 2000),
            'order_status' => $faker->randomElement($array = array ('l','v','s',1,2,3,4)),
            
            'port_id' => $faker->numberBetween($min = 1, $max = 3)
          ]));
      }
    }
}
