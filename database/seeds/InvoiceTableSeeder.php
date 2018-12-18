<?php

use App\Model\Invoice;

use Illuminate\Database\Seeder;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Invoice::create([
        'shipment_id' => 1,
        'price_calculation' => json_decode('[{"tier":1,"quality_metric_id":1,"formula": "IF(typical < 6322, 52, price*(actual-typical)/typical)"},{"tier":2,"quality_metric_id":2,"formula": "IF(typical < 5500, 60, price*(actual-typical)/typical)"},{"tier":3,"quality_metric_id":4,"formula": "IF(typical > 20, 26, price*(actual-reject)/typical)"},{"tier":4,"quality_metric_id":6,"formula": "IF(typical > 15, 30, price*(reject-typical)/typical)"}]'),
        'tonnage_calculation' => json_decode('[{"tier":1,"quality_metric_id":1,"formula": "IF(typical < 6322, 52, price*(actual-typical)/typical)"},{"tier":2,"quality_metric_id":2,"formula": "IF(typical < 5500, 60, price*(actual-typical)/typical)"},{"tier":3,"quality_metric_id":4,"formula": "IF(typical > 20, 26, price*(actual-reject)/typical)"},{"tier":4,"quality_metric_id":6,"formula": "IF(typical > 15, 30, price*(reject-typical)/typical)"}]'),
        'base_currency_id' => 'USD',
        'base_price' => 300,
        'final_base_price' => 280,
        'deal_currency_id' => 'USD',
        'deal_price' => 280,
        'final_deal_price' => 250,
        'exchange_rate' => 1,
        'status' => 'a'
      ]);

      Invoice::create([
        'shipment_id' => 2,
        'price_calculation' => json_decode('[{"tier":1,"quality_metric_id":1,"formula": "IF(typical < 6322, 60, price*(actual-reject)/typical)"},{"tier":2,"quality_metric_id":2,"formula": "IF(typical < 5500, 65, price*(actual-typical)/reject)"},{"tier":3,"quality_metric_id":4,"formula": "IF(typical > 20, 24, price*(actual-reject)/typical)"},{"tier":4,"quality_metric_id":6,"formula": "IF(typical > 15, 25, price*(reject-typical)/typical)"}]'),
        'tonnage_calculation' => json_decode('[{"tier":1,"quality_metric_id":1,"formula": "IF(typical < 6322, 60, price*(actual-reject)/typical)"},{"tier":2,"quality_metric_id":2,"formula": "IF(typical < 5500, 65, price*(actual-typical)/reject)"},{"tier":3,"quality_metric_id":4,"formula": "IF(typical > 20, 24, price*(actual-reject)/typical)"},{"tier":4,"quality_metric_id":6,"formula": "IF(typical > 15, 25, price*(reject-typical)/typical)"}]'),
        'base_currency_id' => 'USD',
        'base_price' => 350,
        'final_base_price' => 325,
        'deal_currency_id' => 'USD',
        'deal_price' => 323,
        'final_deal_price' => 300,
        'exchange_rate' => 1,
        'status' => 'a'
      ]);

      Invoice::create([
        'shipment_id' => 3,
        'price_calculation' => json_decode('[{"tier":1,"quality_metric_id":1,"formula": "IF(typical < 6322, 40, price*(actual-typical)/typical)"},{"tier":2,"quality_metric_id":2,"formula": "IF(typical < 5500, 39, price*(actual-typical)/typical)"},{"tier":3,"quality_metric_id":4,"formula": "IF(typical > 20, 25, price*(actual-reject)/typical)"},{"tier":4,"quality_metric_id":6,"formula": "IF(typical > 15, 10, price*(reject-typical)/typical)"}]'),
        'tonnage_calculation' => json_decode('[{"tier":1,"quality_metric_id":1,"formula": "IF(typical < 6322, 40, price*(actual-typical)/typical)"},{"tier":2,"quality_metric_id":2,"formula": "IF(typical < 5500, 39, price*(actual-typical)/typical)"},{"tier":3,"quality_metric_id":4,"formula": "IF(typical > 20, 25, price*(actual-reject)/typical)"},{"tier":4,"quality_metric_id":6,"formula": "IF(typical > 15, 10, price*(reject-typical)/typical)"}]'),
        'base_currency_id' => 'USD',
        'base_price' => 275,
        'final_base_price' => 250,
        'deal_currency_id' => 'USD',
        'deal_price' => 275,
        'final_deal_price' => 275,
        'exchange_rate' => 1,
        'status' => 'a'
      ]);
    }
}
