<?php

use Illuminate\Database\Seeder;

use App\Model\Shipment;
use App\Model\ShippingInstruction;
use App\Model\Vessel;
use App\Model\Quality;
use App\Model\QualityDetail;
use App\Model\QualityMetric;

class ShipmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Shipment::create([
        'id' => 1,
        'contract_id' => 1,
        'supplier_id' => 4,
        'customer_id' => 1,        
        'product_variant_id' => 1,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP001',
        'vessel_id' => 1,
        'loader_id' => 1,
        'laycan_start_plan' => '2016-07-22',
        'laycan_end_plan' => '2016-08-02',
        'laycan_start_actual' => '2016-07-22',
        'laycan_end_actual' => '2016-08-02',
        'eta' => '2016-08-24',
        'etd' => '2016-08-27',
        'etc' => '2017-03-01',
        'volume' => 74906,
        'demurrage_rate' => 16425,
        'loading_rate' => 17304,
        'currency' => 'USD',
        'price' => 10,
        'status' => 'a',
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
      ]);

      Shipment::create([
        'id' => 2,
        'contract_id' => 2,
        'supplier_id' => 5,
        'customer_id' => 2,        
        'product_variant_id' => 3,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP002',
        'vessel_id' => 2,
        'loader_id' => 2,
        'laycan_start_plan' => '2017-01-16',
        'laycan_end_plan' => '2017-03-12',
        'laycan_start_actual' => '2017-01-16',
        'laycan_end_actual' => '2017-03-12',
        'eta' => '2017-03-02',
        'etd' => '2017-03-13',
        'etc' => '2017-03-10',
        'volume' => 58302,
        'demurrage_rate' => 11087,
        'loading_rate' => 13423,
        'currency' => 'USD',
        'price' => 11,
        'status' => 'a',
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
      ]);

      Shipment::create([
        'id' => 3,
        'contract_id' => 3,
        'supplier_id' => 4,
        'customer_id' => 1,        
        'product_variant_id' => 2,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP003',
        'vessel_id' => 3,
        'loader_id' => 3,
        'laycan_start_plan' => '2017-07-23',
        'laycan_end_plan' => '2017-08-02',
        'laycan_start_actual' => '2017-07-23',
        'laycan_end_actual' => '2017-08-02',
        'eta' => '2017-01-17',
        'etd' => '2017-01-21',
        'etc' => '2017-03-15',
        'volume' => 71991,
        'demurrage_rate' => 14499,
        'loading_rate' => 15851,
        'currency' => 'IDR',
        'price' => 16,
        'status' => 'a',
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
      ]);

      Shipment::create([
        'id' => 4,
        'contract_id' => 1,
        'supplier_id' => 4,
        'customer_id' => 1,        
        'product_variant_id' => 1,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP004',
        'vessel_id' => 3,
        'loader_id' => 4,
        'laycan_start_plan' => '2017-02-25',
        'laycan_end_plan' => '2017-03-01',
        'laycan_start_actual' => '2017-02-25',
        'laycan_end_actual' => '2017-03-01',
        'eta' => '2017-01-17',
        'etd' => '2017-01-21',
        'etc' => '2017-01-01',
        'volume' => 61325,
        'demurrage_rate' => 13529,
        'loading_rate' => 10293,
        'currency' => 'IDR',
        'price' => 13,
        'status' => 'a',
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
      ]);

      Shipment::create([
        'id' => 5,
        'contract_id' => 1,
        'supplier_id' => 4,
        'customer_id' => 1,        
        'product_variant_id' => 1,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP005',
        'vessel_id' => 1,
        'loader_id' => 5,
        'laycan_start_plan' => '2017-01-02',
        'laycan_end_plan' => '2017-01-15',
        'laycan_start_actual' => '2017-01-02',
        'laycan_end_actual' => '2017-01-15',
        'eta' => '2017-01-17',
        'etd' => '2017-01-21',
        'etc' => '2017-01-28',
        'volume' => 61325,
        'demurrage_rate' => 13529,
        'loading_rate' => 10293,
        'currency' => 'USD',
        'price' => 13,
        'status' => 'a',
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
      ]);

      Shipment::create([
        'id' => 6,
        'contract_id' => 1,
        'supplier_id' => 4,
        'customer_id' => 1,        
        'product_variant_id' => 1,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP006',
        'vessel_id' => 1,
        'loader_id' => 6,
        'laycan_start_plan' => '2017-01-25',
        'laycan_end_plan' => '2017-01-31',
        'laycan_start_actual' => '2017-01-25',
        'laycan_end_actual' => '2017-01-31',
        'eta' => '2017-01-27',
        'etd' => '2017-01-31',
        'etc' => '2017-02-02',
        'volume' => 61005,
        'demurrage_rate' => 13529,
        'loading_rate' => 10293,
        'currency' => 'IDR',
        'price' => 13,
        'status' => 'a',
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
      ]);

      Shipment::create([
        'id' => 7,
        'contract_id' => 2,
        'supplier_id' => 5,
        'customer_id' => 2,        
        'product_variant_id' => 3,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP007',
        'vessel_id' => 2,
        'loader_id' => 7,
        'laycan_start_plan' => '2017-03-02',
        'laycan_end_plan' => '2017-03-15',
        'laycan_start_actual' => '2017-03-02',
        'laycan_end_actual' => '2017-03-15',
        'eta' => '2017-03-17',
        'etd' => '2017-03-21',
        'etc' => '2017-02-27',
        'volume' => 73315,
        'demurrage_rate' => 13529,
        'loading_rate' => 10293,
        'currency' => 'USD',
        'price' => 13,
        'status' => 'a',
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
      ]);

      Vessel::create([
        'id' => 1,
        'vessel_name' => 'MV. ANDHIKA PARAMESTI',
        'flag' => 'flag 1',
        'build' => 'build 1',
        'deadweight_tonnage' => 100.2,
        'length_overall' => 50.2,
        'beam' => 20.2,
        'containers' => 'containers 1',
        'status' => 'a'
      ]);

      Vessel::create([
        'id' => 2,
        'vessel_name' => 'NIL',
        'flag' => 'flag 2',
        'build' => 'build 2',
        'deadweight_tonnage' => 100.3,
        'length_overall' => 50.3,
        'beam' => 20.3,
        'containers' => 'containers 2',
        'status' => 'a'
      ]);

      Vessel::create([
        'id' => 3,
        'vessel_name' => 'MV. JUNJIE',
        'flag' => 'flag 3',
        'build' => 'build 3',
        'deadweight_tonnage' => 100.4,
        'length_overall' => 50.4,
        'beam' => 20.4,
        'containers' => 'containers 3',
        'status' => 'a'
      ]);

      Vessel::create([
        'id' => 4,
        'vessel_name' => 'MV. YUE DIAN 8',
        'flag' => 'flag 3',
        'build' => 'build 3',
        'deadweight_tonnage' => 100.4,
        'length_overall' => 50.4,
        'beam' => 20.4,
        'containers' => 'containers 3',
        'status' => 'a'
      ]);

      Vessel::create([
        'id' => 5,
        'vessel_name' => 'MV. YAN DUN JIAO 1',
        'flag' => 'flag 3',
        'build' => 'build 3',
        'deadweight_tonnage' => 100.4,
        'length_overall' => 50.4,
        'beam' => 20.4,
        'containers' => 'containers 3',
        'status' => 'a'
      ]);

      QualityMetric::create([
        'quality' => 'NCV',
        'metric' => 'Kcal/Kg'
      ]);

      QualityMetric::create([
        'quality' => 'GCV ADB',
        'metric' => 'Kcal'
      ]);

      QualityMetric::create([
        'quality' => 'GCV ARB',
        'metric' => 'Kcal'
      ]);

      QualityMetric::create([
        'quality' => 'Ash',
        'metric' => '%'
      ]);

      QualityMetric::create([
        'quality' => 'Sulphur',
        'metric' => '%'
      ]);

      QualityMetric::create([
        'quality' => 'TM',
        'metric' => '%'
      ]);

      QualityMetric::create([
        'quality' => 'IM',
        'metric' => '%'
      ]);

      QualityMetric::create([
        'quality' => 'FC',
        'metric' => '%'
      ]);

      QualityMetric::create([
        'quality' => 'VM',
        'metric' => '%'
      ]);

      QualityMetric::create([
        'quality' => 'HGI',
        'metric' => '%'
      ]);

      QualityMetric::create([
        'quality' => 'Size',
        'metric' => '%'
      ]);

      QualityMetric::create([
        'quality' => 'AFT',
        'metric' => 'deg C'
      ]);

      QualityMetric::create([
        'quality' => 'Na2O',
        'metric' => '%'
      ]);

      Quality::create([
        'shipment_id' => 1,
        'contract_id' =>2,
        'status' => 'a',
        'type' => 't'
      ]);
      Quality::create([
        'shipment_id' => 1,
        'contract_id' =>2,
        'status' => 'a',
        'type' => 'a'
      ]);
      Quality::create([
        'shipment_id' => 1,
        'contract_id' =>2,
        'status' => 'a',
        'type' => 'r'
      ]);
      Quality::create([
        'shipment_id' => 2,
        'contract_id' => 1,
        'status' => 'a',
        'type' => 't'
      ]);
      QualityDetail::create([
        'quality_id' => 1,
        'value' => 2000,
        'quality_metrics_id' => 1
      ]);
      QualityDetail::create([
        'quality_id' => 1,
        'value' => 2300,
        'quality_metrics_id' => 2
      ]);
      QualityDetail::create([
        'quality_id' => 1,
        'value' => 1300,
        'quality_metrics_id' => 3
      ]);
      QualityDetail::create([
        'quality_id' => 2,
        'value' => 2100,
        'quality_metrics_id' => 1
      ]);
      QualityDetail::create([
        'quality_id' => 2,
        'value' => 2200,
        'quality_metrics_id' => 2
      ]);

      QualityDetail::create([
        'quality_id' => 3,
        'value' => 2450,
        'quality_metrics_id' => 1
      ]);
      QualityDetail::create([
        'quality_id' => 3,
        'value' => 2345,
        'quality_metrics_id' => 2
      ]);

      ShippingInstruction::create([
        'shipment_id' => 1,
        'si_no' => '123412312',
        'si_date' => '2017-05-20',
        'shipper_details' => 'PT Berau Coal, Tbk',
        'consignee' => 'Huaneng',
        'loading_port' => 'Tg Redeb',
        'destination_port' => 'Any Port in China',
        'goods_desc' => 'Coal in Bulk',
        'qty' => 9100,
        'qty_tolerence' => 10,
        'witness' => 'TBN',
        'lc_no' => 'HKBM0002186',
        'docs_berau' => 'nothing',
        'docs_shipping' => 'nothing',
        'docs_surveyor' => 'nothing',
        'analysis_method' => 'ISO',
        'sample_size' => '10',
        'sample_weight' => '1',
        'sample_address' => 'Jl Anam',
        'status' => 'c'
      ]);
    }
}
