<?php

use Illuminate\Database\Seeder;

use App\Model\ShipmentPlan;

class ShipmentPlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      ShipmentPlan::create([
        'contract_id' => 1,
        'product_variant_id' => 1,
        'laycan_start' => '2016-04-22',
        'laycan_end' => '2016-05-02',
        'volume' => 74906,
        'status' => 'a',
      ]);

      ShipmentPlan::create([
        'contract_id' => 2,
        'product_variant_id' => 2,
        'laycan_start' => '2016-07-01',
        'laycan_end' => '2016-08-20',
        'volume' => 52135,
        'status' => 'a',
      ]);

      ShipmentPlan::create([
        'contract_id' => 3,
        'product_variant_id' => 3,
        'laycan_start' => '2016-07-22',
        'laycan_end' => '2016-08-02',
        'volume' => 62123,
        'status' => 'a',
      ]);

      ShipmentPlan::create([
        'contract_id' => 1,
        'product_variant_id' => 1,
        'laycan_start' => '2017-04-22',
        'laycan_end' => '2017-08-02',
        'volume' => 62123,
        'status' => 'a',
      ]);

      ShipmentPlan::create([
        'contract_id' => 2,
        'product_variant_id' => 2,
        'laycan_start' => '2017-04-22',
        'laycan_end' => '2017-08-02',
        'volume' => 72154,
        'status' => 'a',
      ]);

      ShipmentPlan::create([
        'contract_id' => 3,
        'product_variant_id' => 3,
        'laycan_start' => '2017-04-22',
        'laycan_end' => '2017-09-02',
        'volume' => 345134,
        'status' => 'a',
      ]);

      ShipmentPlan::create([
        'contract_id' => 4,
        'product_variant_id' => 4,
        'laycan_start' => '2017-04-22',
        'laycan_end' => '2017-05-02',
        'volume' => 52674,
        'status' => 'a',
      ]);

      ShipmentPlan::create([
        'contract_id' => 1,
        'product_variant_id' => 5,
        'laycan_start' => '2017-04-22',
        'laycan_end' => '2017-06-02',
        'volume' => 34545,
        'status' => 'a',
      ]);

      ShipmentPlan::create([
        'contract_id' => 2,
        'product_variant_id' => 6,
        'laycan_start' => '2017-04-22',
        'laycan_end' => '2017-07-02',
        'volume' => 62341,
        'status' => 'a',
      ]);
    }
}
