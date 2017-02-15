<?php

use App\Model\Lead;
use App\Model\Order;
use App\Model\OrderNegotiation;
use App\Model\ExchangeRate;
use App\Model\Currency;

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
      'user_id' => 3,
      'company_id' => 4,
      'order_date' => '2016-11-16',
      'order_expired' => '2016-11-30',
      'laycan_start' => '2016-11-19',
      'laycan_end' => '2016-11-21',
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
      'product_id' => 3,
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
      'na20_min' => 1200,
      'na20_max' => 1300,
      'na20_reject' => NULL,
      'na20_bonus' => NULL,
      'volume' => 7500,
      'price' => 52,
      'currency' => 'USD',
      'trading_term' => 'FOB',
      'trading_term_detail' => 'MV',
      'payment_term' => 'LC on Sight',
      'remarks' => NULL,
      'carrier_type' => 'Geared',
      'lead_type' => config('app.showBuy') ? 'b' : 's' ,
      'order_status' => 's',
      'progress_status' => NULL
    ]);

    Lead::create([
      'user_id' => 3,
      'company_id' => 2,
      'order_date' => '2016-11-16',
      'order_expired' => '2016-11-25',
      'laycan_start' => '2016-11-20',
      'laycan_end' => '2016-11-22',
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
      'product_id' => 6,
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
      'na20_min' => 1200,
      'na20_max' => 1300,
      'na20_reject' => NULL,
      'na20_bonus' => NULL,
      'volume' => 7500,
      'price' => 60,
      'currency' => 'USD',
      'trading_term' => 'FOB',
      'trading_term_detail' => 'Barge',
      'payment_term' => 'TT',
      'remarks' => NULL,
      'carrier_type' => 'Gearless',
      'lead_type' => 's',
      'order_status' => 's',
      'progress_status' => NULL
    ]);

    Lead::create([
      'user_id' => 3,
      'company_id' => 2,
      'order_date' => '2016-11-16',
      'order_expired' => '2016-11-25',
      'laycan_start' => '2016-11-20',
      'laycan_end' => '2016-11-22',
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
      'product_id' => 6,
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
      'na20_min' => 1200,
      'na20_max' => 1300,
      'na20_reject' => NULL,
      'na20_bonus' => NULL,
      'volume' => 7500,
      'price' => 60,
      'currency' => 'USD',
      'trading_term' => 'FOB',
      'trading_term_detail' => 'Barge',
      'payment_term' => 'TT',
      'remarks' => NULL,
      'carrier_type' => 'Gearless',
      'lead_type' => 's',
      'order_status' => 's',
      'progress_status' => NULL
    ]);

    Lead::create([
      'user_id' => 1,
      'company_id' => 4,
      'order_date' => '2016-11-16',
      'order_expired' => '2016-11-25',
      'laycan_start' => '2016-11-20',
      'laycan_end' => '2016-11-22',
      'concession_id' => 1,
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
      'product_id' => 6,
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
      'na20_min' => 1200,
      'na20_max' => 1300,
      'na20_reject' => NULL,
      'na20_bonus' => NULL,
      'volume' => 7500,
      'price' => 60,
      'currency' => 'USD',
      'trading_term' => 'FOB',
      'trading_term_detail' => 'Barge',
      'payment_term' => 'TT',
      'remarks' => NULL,
      'carrier_type' => 'Gearless',
      'lead_type' => config('app.showBuy') ? 'b' : 's' ,
      'order_status' => 'l',
      'progress_status' => NULL
    ]);

    Lead::create([
      'user_id' => 2,
      'company_id' => 5,
      'order_date' => '2016-11-16',
      'order_expired' => '2016-11-25',
      'laycan_start' => '2016-11-20',
      'laycan_end' => '2016-11-22',
      'concession_id' => 3,
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
      'product_id' => 6,
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
      'na20_min' => 1200,
      'na20_max' => 1300,
      'na20_reject' => NULL,
      'na20_bonus' => NULL,
      'volume' => 7500,
      'price' => 60,
      'currency' => 'USD',
      'trading_term' => 'FOB',
      'trading_term_detail' => 'Barge',
      'payment_term' => 'TT',
      'remarks' => NULL,
      'carrier_type' => 'Geared',
      'lead_type' => config('app.showBuy') ? 'b' : 's' ,
      'order_status' => 'v',
      'progress_status' => NULL
    ]);

    Lead::create([
      'user_id' => 3,
      'company_id' => 7,
      'order_date' => '2016-11-16',
      'order_expired' => '2016-11-25',
      'laycan_start' => '2016-11-20',
      'laycan_end' => '2016-11-22',
      'concession_id' => 5,
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
      'product_id' => 6,
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
      'na20_min' => 1200,
      'na20_max' => 1300,
      'na20_reject' => NULL,
      'na20_bonus' => NULL,
      'volume' => 7500,
      'price' => 60,
      'currency' => 'USD',
      'trading_term' => 'FOB',
      'trading_term_detail' => 'Barge',
      'payment_term' => 'TT',
      'remarks' => NULL,
      'carrier_type' => 'Geared',
      'lead_type' => config('app.showBuy') ? 'b' : 's' ,
      'order_status' => 'p',
      'progress_status' => NULL
    ]);


    Lead::create([
      'user_id' => 1,
      'company_id' => 2,
      'order_date' => '2016-11-16',
      'order_expired' => '2016-11-25',
      'laycan_start' => '2016-11-20',
      'laycan_end' => '2016-11-22',
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
      'product_id' => 6,
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
      'na20_min' => 1200,
      'na20_max' => 1300,
      'na20_reject' => NULL,
      'na20_bonus' => NULL,
      'volume' => 7500,
      'price' => 60,
      'currency' => 'USD',
      'trading_term' => 'FOB',
      'trading_term_detail' => 'Barge',
      'payment_term' => 'TT',
      'remarks' => NULL,
      'carrier_type' => 'Geared',
      'lead_type' => 's',
      'order_status' => 'l',
      'progress_status' => NULL
    ]);


    Lead::create([
      'user_id' => 2,
      'company_id' => 1,
      'order_date' => '2016-11-16',
      'order_expired' => '2016-11-25',
      'laycan_start' => '2016-11-20',
      'laycan_end' => '2016-11-22',
      'factory_id' => 1,
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
      'product_id' => 6,
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
      'na20_min' => 1200,
      'na20_max' => 1300,
      'na20_reject' => NULL,
      'na20_bonus' => NULL,
      'volume' => 7500,
      'price' => 60,
      'currency' => 'USD',
      'trading_term' => 'FOB',
      'trading_term_detail' => 'Barge',
      'payment_term' => 'TT',
      'remarks' => NULL,
      'carrier_type' => 'Geared',
      'lead_type' => 's',
      'order_status' => 'v',
      'progress_status' => NULL
    ]);


    Lead::create([
      'user_id' => 4,
      'company_id' => 2,
      'order_date' => '2016-11-16',
      'order_expired' => '2016-11-25',
      'laycan_start' => '2016-11-20',
      'laycan_end' => '2016-11-22',
      'factory_id' => 3,
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
      'product_id' => 6,
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
      'na20_min' => 1200,
      'na20_max' => 1300,
      'na20_reject' => NULL,
      'na20_bonus' => NULL,
      'volume' => 7500,
      'price' => 60,
      'currency' => 'USD',
      'trading_term' => 'FOB',
      'trading_term_detail' => 'Barge',
      'payment_term' => 'TT',
      'remarks' => NULL,
      'carrier_type' => 'Geared',
      'lead_type' => 's',
      'order_status' => 'p',
      'progress_status' => NULL
    ]);

    Currency::create([
      'id' => 'USD',
      'value' => 'United States Dollar'
    ]);

    Currency::create([
      'id' => 'IDR',
      'value' => 'Indonesian Rupiah'
    ]);

    Currency::create([
      'id' => 'AUD',
      'value' => 'Australian Dollar'
    ]);

    Currency::create([
      'id' => 'BGN',
      'value' => 'Bulgarian Lev'
    ]);

    Currency::create([
      'id' => 'BRL',
      'value' => 'Brazil Real'
    ]);

    Currency::create([
      'id' => 'CAD',
      'value' => 'Canadian Dollar'
    ]);

    Currency::create([
      'id' => 'CHF',
      'value' => 'Swiss Franc'
    ]);

    Currency::create([
      'id' => 'CNY',
      'value' => 'Chinese Yuan'
    ]);

    Currency::create([
      'id' => 'CZK',
      'value' => 'Czech Koruna'
    ]);

    Currency::create([
      'id' => 'DKK',
      'value' => 'Danish Krone'
    ]);

    Currency::create([
      'id' => 'EUR',
      'value' => 'Euro'
    ]);

    Currency::create([
      'id' => 'GBP',
      'value' => 'British Pound'
    ]);

    Currency::create([
      'id' => 'HKD',
      'value' => 'Hong Kong Dollar'
    ]);

    Currency::create([
      'id' => 'HRK',
      'value' => 'Croatian Kuna'
    ]);

    Currency::create([
      'id' => 'HUF',
      'value' => 'Hungarian Forint'
    ]);

    Currency::create([
      'id' => 'ILS',
      'value' => 'Israeli Sheqel'
    ]);

    Currency::create([
      'id' => 'INR',
      'value' => 'Indian Rupee'
    ]);

    Currency::create([
      'id' => 'JPY',
      'value' => 'Japanese Yen'
    ]);

    Currency::create([
      'id' => 'KRW',
      'value' => 'South Korean Won'
    ]);

    Currency::create([
      'id' => 'MXN',
      'value' => 'Mexico Peso'
    ]);

    Currency::create([
      'id' => 'MYR',
      'value' => 'Malaysia Ringgit'
    ]);

    Currency::create([
      'id' => 'NOK',
      'value' => 'Norway Krone'
    ]);

    Currency::create([
      'id' => 'NZD',
      'value' => 'New Zealand Dollar'
    ]);

    Currency::create([
      'id' => 'PHP',
      'value' => 'Philippine Peso'
    ]);

    Currency::create([
      'id' => 'PLN',
      'value' => 'Poland Zloty'
    ]);

    Currency::create([
      'id' => 'RON',
      'value' => 'Romanian Lei'
    ]);

    Currency::create([
      'id' => 'RUB',
      'value' => 'Russian Rouble'
    ]);

    Currency::create([
      'id' => 'SEK',
      'value' => 'Swedish Krona'
    ]);

    Currency::create([
      'id' => 'SGD',
      'value' => 'Singapore Dollar'
    ]);

    Currency::create([
      'id' => 'THB',
      'value' => 'Thailand Baht'
    ]);

    Currency::create([
      'id' => 'TRY',
      'value' => 'Turkish Lira'
    ]);

    Currency::create([
      'id' => 'ZAR',
      'value' => 'South African Rand'
    ]);


    ExchangeRate::create([
      'buy' => 'USD',
      'sell' => 'IDR',
      'value' => 13500,
      'in_use' => true
    ]);

    ExchangeRate::create([
      'buy' => 'IDR',
      'sell' => 'USD',
      'value' => 0.00007407407,
      'in_use' => false
    ]);

    ExchangeRate::create([
      'buy' => 'USD',
      'sell' => 'IDR',
      'value' => 13300,
      'in_use' => false
    ]);

    ExchangeRate::create([
      'buy' => 'IDR',
      'sell' => 'USD',
      'value' => 0.00007507407,
      'in_use' => true
    ]);

   $orders = [
     [
      'order' => [ 'id' => 1, 'user_id' => 3, 'index_id' => 3, 'status' => 'p', 'approval_sequence' => 0, 'in_house' => false || !config('app.showBuy') ],
      'leads' => [
          1 => [ 'volume' => 1000, 'price' => 25, 'trading_term' => 'FOB MV', 'payment_term' => 'TT', 'base_currency_id' => 'IDR', 'base_price' => 50000, 'deal_currency_id' => 'USD', 'deal_price' => 50, 'exchange_rate' => 10000 ],
          2 => [ 'volume' => 1000, 'price' => 53, 'trading_term' => 'FOB MV', 'payment_term' => 'TT', 'base_currency_id' => 'IDR', 'base_price' => 50000, 'deal_currency_id' => 'USD', 'deal_price' => 50, 'exchange_rate' => 10000  ]
      ],
      'user' => [ 1 => [ 'role' => 'approver' ], 2 => [ 'role' => 'associated' ], 3 => [ 'role' => 'admin' ] ],
      'approval' => [ 1 => [ 'status' => 'p', 'approval_token' => 'aaa' ], 2 => [ 'status' => 'a', 'approval_token' => 'bbb' ] ],
      'companies' => [ 1 => [ 'cost' => 3 ] ]
     ],
     [
      'order' => [ 'id' => 2, 'user_id' => 9, 'index_id' => 3, 'status' => 'a', 'approval_sequence' => 0, 'in_house' => true || !config('app.showBuy') ],
      'leads' => [
          3 => [ 'volume' => 1000, 'price' => 51, 'trading_term' => 'FOB MV', 'payment_term' => 'TT', 'base_currency_id' => 'IDR', 'base_price' => 50000, 'deal_currency_id' => 'USD', 'deal_price' => 50, 'exchange_rate' => 10000  ]
      ],
      'user' => [ 1 => [ 'role' => 'approver' ], 2 => [ 'role' => 'associated' ], 3 => [ 'role' => 'admin' ] ],
      'approval' => [ 1 => [ 'status' => 'a', 'approval_token' => 'aaa' ], 2 => [ 'status' => 'a', 'approval_token' => 'bbb' ] ],
      'companies' => [ 1 => [ 'cost' => 3 ] ]
     ],
     [
      'order' => [ 'id' => 3, 'user_id' => 10, 'index_id' => 2, 'status' => 'f', 'approval_sequence' => 0, 'in_house' => false || !config('app.showBuy') ],
      'leads' => [
          4 => [ 'volume' => 2000, 'price' => 35, 'trading_term' => 'FOB MV', 'payment_term' => 'TT', 'base_currency_id' => 'IDR', 'base_price' => 50000, 'deal_currency_id' => 'USD', 'deal_price' => 50, 'exchange_rate' => 10000  ],
          7 => [ 'volume' => 1600, 'price' => 55, 'trading_term' => 'FOB MV', 'payment_term' => 'TT', 'base_currency_id' => 'IDR', 'base_price' => 50000, 'deal_currency_id' => 'USD', 'deal_price' => 50, 'exchange_rate' => 10000  ]
      ],
      'user' => [ 4 => [ 'role' => 'associated' ], 3 => [ 'role' => 'associated' ], 1 => [ 'role' => 'approver' ] ],
      'approval' => [ 1 => [ 'status' => 'a', 'approval_token' => 'aaa' ], 2 => [ 'status' => 'a', 'approval_token' => 'bbb' ] ],
      'companies' => [ 1 => [ 'cost' => 3 ] ]
     ],
     [
      'order' => [ 'id' => 4, 'user_id' => 9, 'index_id' => 3, 'status' => 'd', 'approval_sequence' => 0, 'in_house' => false || !config('app.showBuy') ],
      'leads' => [
          3 => [ 'volume' => 1300, 'price' => 45, 'trading_term' => 'FOB MV', 'payment_term' => 'TT', 'base_currency_id' => 'IDR', 'base_price' => 50000, 'deal_currency_id' => 'USD', 'deal_price' => 50, 'exchange_rate' => 10000  ],
          6 => [ 'volume' => 1800, 'price' => 55, 'trading_term' => 'FOB MV', 'payment_term' => 'TT', 'base_currency_id' => 'IDR', 'base_price' => 50000, 'deal_currency_id' => 'USD', 'deal_price' => 50, 'exchange_rate' => 10000  ]
      ],
      'companies' => [ 1 => [ 'cost' => 3 ] ]
     ]
   ];

   foreach($orders as $obj){
      $order = Order::create($obj['order']);

      if(isset($obj['leads'])) $order->leads()->attach($obj['leads']);
      if(isset($obj['user'])) $order->users()->attach($obj['user']);
      $order->companies()->attach($obj['companies']);
      if(isset($obj['approval'])) $order->approvals()->attach($obj['approval']);
   }

    OrderNegotiation::create([
      'order_detail_id' => 1,
      'user_id' => 3,
      'volume' => 1000,
      'base_currency_id' => 'IDR', 'base_price' => 50000, 'deal_currency_id' => 'USD', 'deal_price' => 50, 'exchange_rate' => 10000,
      'trading_term' => 'FOB MV',
      'payment_term' => 'NET30',
      'notes' => 'Initial Deal',
    ]);
    OrderNegotiation::create([
      'order_detail_id' => 1,
      'user_id' => 3,
      'volume' => 1000,
      'base_currency_id' => 'IDR', 'base_price' => 50000, 'deal_currency_id' => 'USD', 'deal_price' => 50, 'exchange_rate' => 10000,
      'trading_term' => 'FOB MV',
      'payment_term' => 'TT',
      'notes' => 'Price decreased, they agreed, but need to wire as fast as possible',
    ]);


  }
}
