<?php

use App\Model\Lead;
use App\Model\Order;
use App\Model\OrderNegotiation;

use Illuminate\Database\Seeder;

class LeadsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Lead::create([
      'user_id' => 6,
      'company_id' => 3,
      'order_date' => '2016-11-16',
      'order_expired' => '2016-11-30',
      'laycan_start' => '2016-11-21',
      'laycan_end' => '2016-11-19',
      'concession_id' => 4,
      'address' => '',
      'city' => 'Angsana',
      'country' => 'Indonesia',
      'latitude' => '-3.00000000',
      'longitude' => '115.00000000',
      'port_distance' => 25,
      'port_id' => 3,
      'port_name' => 'Jetty BIB',
      'port_status' => '1',
      'port_daily_rate' => 40,
      'port_draft_height' => 0,
      'port_latitude' => '-3.76687876',
      'port_longitude' => '115.60575204',
      'product_name' => 'BIB 4200',
      'typical_quality' => '4200',
      'product_id' => 9,
      'gcv_arb_min' => 4000,
      'gcv_arb_max' => 4200,
      'gcv_arb_reject' => '>4200',
      'gcv_arb_bonus' => '<4000',
      'gcv_adb_min' => 5300,
      'gcv_adb_max' => 5500,
      'gcv_adb_reject' => NULL,
      'gcv_adb_bonus' => NULL,
      'ncv_min' => 3600,
      'ncv_max' => 3800,
      'ncv_reject' => NULL,
      'ncv_bonus' => NULL,
      'ash_min' => '5.00',
      'ash_max' => '7.00',
      'ash_reject' => NULL,
      'ash_bonus' => NULL,
      'ts_min' => '1.00',
      'ts_max' => '1.00',
      'ts_reject' => NULL,
      'ts_bonus' => NULL,
      'tm_min' => '36.00',
      'tm_max' => '37.00',
      'tm_reject' => NULL,
      'tm_bonus' => NULL,
      'im_min' => '14.00',
      'im_max' => '16.00',
      'im_reject' => NULL,
      'im_bonus' => NULL,
      'fc_min' => '36.00',
      'fc_max' => '38.00',
      'fc_reject' => NULL,
      'fc_bonus' => NULL,
      'vm_min' => '40.00',
      'vm_max' => '42.00',
      'vm_reject' => NULL,
      'vm_bonus' => NULL,
      'hgi_min' => 60,
      'hgi_max' => 65,
      'hgi_reject' => NULL,
      'hgi_bonus' => NULL,
      'size_min' => 90,
      'size_max' => 90,
      'size_reject' => NULL,
      'size_bonus' => NULL,
      'fe2o3_min' => NULL,
      'fe2o3_max' => NULL,
      'fe2o3_reject' => NULL,
      'fe2o3_bonus' => NULL,
      'aft_min' => 1100,
      'aft_max' => 1200,
      'aft_reject' => NULL,
      'aft_bonus' => NULL,
      'volume' => 7500,
      'price' => 52,
      'trading_term' => 'FOB',
      'trading_term_detail' => 'MV',
      'payment_term' => 'LC on Sight',
      'commercial_term' => NULL,
      'penalty' => NULL,
      'lead_type' => 'b',
      'order_status' => 's',
      'progress_status' => NULL
    ]);

    Lead::create([
      'user_id' => 7,
      'company_id' => 2,
      'order_date' => '2016-11-16',
      'order_expired' => '2016-11-25',
      'laycan_start' => '2016-11-22',
      'laycan_end' => '2016-11-20',
      'factory_id' => 2,
      'address' => 'Jl. Rungkut Industri X No.6, Rungkut Tengah, Gn. Anyar, Kota SBY, Jawa Timur 60293',
      'city' => 'Jawa Timur',
      'country' => 'INA',
      'latitude' => '-7.33489690',
      'longitude' => '112.76469390',
      'port_distance' => 200,
      'port_id' => 5,
      'port_name' => 'Jetty Gresik',
      'port_status' => '0',
      'port_daily_rate' => 8,
      'port_draft_height' => 8,
      'port_latitude' => '-7.14177358',
      'port_longitude' => '112.64212962',
      'product_name' => '4200',
      'typical_quality' => '4200',
      'product_id' => 10,
      'gcv_arb_min' => 4000,
      'gcv_arb_max' => 4200,
      'gcv_arb_reject' => '> 4200',
      'gcv_arb_bonus' => '< 4000',
      'gcv_adb_min' => 5300,
      'gcv_adb_max' => 5500,
      'gcv_adb_reject' => NULL,
      'gcv_adb_bonus' => NULL,
      'ncv_min' => 3800,
      'ncv_max' => 4000,
      'ncv_reject' => NULL,
      'ncv_bonus' => NULL,
      'ash_min' => '5.00',
      'ash_max' => '7.00',
      'ash_reject' => NULL,
      'ash_bonus' => NULL,
      'ts_min' => '1.00',
      'ts_max' => '1.00',
      'ts_reject' => NULL,
      'ts_bonus' => NULL,
      'tm_min' => '36.00',
      'tm_max' => '38.00',
      'tm_reject' => NULL,
      'tm_bonus' => NULL,
      'im_min' => '13.00',
      'im_max' => '15.00',
      'im_reject' => NULL,
      'im_bonus' => NULL,
      'fc_min' => '40.00',
      'fc_max' => '42.00',
      'fc_reject' => NULL,
      'fc_bonus' => NULL,
      'vm_min' => '40.00',
      'vm_max' => '42.00',
      'vm_reject' => NULL,
      'vm_bonus' => NULL,
      'hgi_min' => 50,
      'hgi_max' => 60,
      'hgi_reject' => NULL,
      'hgi_bonus' => NULL,
      'size_min' => 90,
      'size_max' => 90,
      'size_reject' => NULL,
      'size_bonus' => NULL,
      'fe2o3_min' => NULL,
      'fe2o3_max' => NULL,
      'fe2o3_reject' => NULL,
      'fe2o3_bonus' => NULL,
      'aft_min' => 1200,
      'aft_max' => 1300,
      'aft_reject' => NULL,
      'aft_bonus' => NULL,
      'volume' => 7500,
      'price' => 60,
      'trading_term' => 'FOB',
      'trading_term_detail' => 'Barge',
      'payment_term' => 'TT',
      'commercial_term' => NULL,
      'penalty' => NULL,
      'lead_type' => 's',
      'order_status' => 's',
      'progress_status' => NULL
    ]);


    $object = [
      'order' => [ 'id' => 1, 'user_id' => 7, 'status' => 'p', ],
      'leads' => [
          1 => [ 'volume' => 500, 'price' => 25000, 'trading_term' => 'FOB MV', 'payment_term' => 'TT' ],
          2 => [ 'volume' => 1000, 'price' => 53000, 'trading_term' => 'FOB MV', 'payment_term' => 'TT' ] 
      ],
      'user' => [ 1 => [ 'role' => 'approver' ], 8 => [ 'role' => 'associated' ], 7 => [ 'role' => 'admin' ] ],
      'approval' => [ 1 => [ 'status' => 'a', 'token' => 'aaa' ], 2 => [ 'status' => 'a', 'token' => 'bbb' ] ],
      'companies' => [ 1 => [ 'cost' => 3 ] ]
    ];

    $order = Order::create($object['order']);
    if(isset($object['leads'])) $order->leads()->attach($object['leads']);
    $order->users()->attach($object['user']);
    $order->companies()->attach($object['companies']);
    $order->approvals()->attach($object['approval']);

    OrderNegotiation::create([
      'order_detail_id' => 1,
      'user_id' => 1,
      'volume' => 500,
      'price' => 50,
      'trading_term' => 'FOB MV',
      'payment_term' => 'NET30',
      'notes' => 'Initial Deal',
    ]);
    OrderNegotiation::create([
      'order_detail_id' => 1,
      'user_id' => 1,
      'volume' => 500,
      'price' => 49,
      'trading_term' => 'FOB MV',
      'payment_term' => 'TT',
      'notes' => 'Price decreased by 1, they agreed, but need to wire as fast as possible',
    ]);


  }
}
