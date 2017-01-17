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
          'contract_no' => 'afdsfad',
          'order_id' => 3,
          'shipment_count' => 12,
          'term' => 'uyuyugy',
          'term_desc' => 'hguyjh',
          'date_from' => new DateTime,
          'date_to' => new DateTime,
          'status' => 'a'
        )

      );

      DB::table('contracts')->insert($contracts);
    }
}
