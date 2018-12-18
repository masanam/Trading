<?php

use App\Model\ContractCalculation;

use Illuminate\Database\Seeder;

class ContractCalculationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      ContractCalculation::create([
        'contract_id' => 1,
        'price_calculation' => json_decode('[{"tier":1,"quality_metric_id":1,"formula": "IF(typical < 6322, 52, price*(actual-typical)/typical)"},{"tier":2,"quality_metric_id":2,"formula": "IF(typical < 5500, 60, price*(actual-typical)/typical)"},{"tier":3,"quality_metric_id":4,"formula": "IF(typical > 20, 26, price*(actual-reject)/typical)"},{"tier":4,"quality_metric_id":6,"formula": "IF(typical > 15, 30, price*(reject-typical)/typical)"}]'),
        'tonnage_calculation' => json_decode('[{"tier":1,"quality_metric_id":1,"formula": "IF(typical < 6322, 52, price*(actual-typical)/typical)"},{"tier":2,"quality_metric_id":2,"formula": "IF(typical < 5500, 60, price*(actual-typical)/typical)"},{"tier":3,"quality_metric_id":4,"formula": "IF(typical > 20, 26, price*(actual-reject)/typical)"},{"tier":4,"quality_metric_id":6,"formula": "IF(typical > 15, 30, price*(reject-typical)/typical)"}]')
      ]);
    }
}
