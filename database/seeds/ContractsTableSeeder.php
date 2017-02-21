<?php

use Illuminate\Database\Seeder;

class ContractsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('contracts')->delete();

      $contracts = array(
        array(
          'contract_no' => '086.PJ/061/YEC/2008',
          'order_id' => 3,
          'area_id' => 1,
          'shipment_count' => 12,
          'term' => 'term',
          'term_desc' => 'Lorem Ipsum Doloret Sit Amet',
          'date_from' => '2016-09-12',
          'date_to' => '2017-01-12',
          'status' => 'a'
        ),
        array(
          'contract_no' => '065.PJ/061/NFW/2008',
          'order_id' => 1,
          'area_id' => 2,
          'shipment_count' => 6,
          'term' => 'spot',
          'term_desc' => 'Lorem Ipsum Doloret Sit Amet',
          'date_from' => '2016-12-12',
          'date_to' => '2017-12-12',
          'status' => 'a'
        ),
        array(
          'contract_no' => '040.PJ/061/YWX/2008',
          'order_id' => 2,
          'area_id' => 3,
          'shipment_count' => 8,
          'term' => 'term',
          'term_desc' => 'Lorem Ipsum Doloret Sit Amet',
          'date_from' => '2016-07-09',
          'date_to' => '2017-07-09',
          'status' => 'a'
        ),
        array(
          'contract_no' => '065.PJ/061/IRN/2008',
          'order_id' => 4,
          'area_id' => 4,
          'shipment_count' => 9,
          'term' => 'term',
          'term_desc' => 'Lorem Ipsum Doloret Sit Amet',
          'date_from' => '2016-08-29',
          'date_to' => '2017-08-29',
          'status' => 'a'
        )
      );

      DB::table('contracts')->insert($contracts);
    }
}
