<?php

use Illuminate\Database\Seeder;

use App\Model\Shipment;

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
        'product_id' => 1,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP001',
        'vessel' => 'Lithgow',
        'laycan_start' => '2016-07-22',
        'laycan_end' => '2016-08-02',
        'eta' => '2016-08-24',
        'etd' => '2016-08-27',
        'volume' => 74906,
        'demurrage_rate' => 16425,
        'loading_rate' => 17304,
        'price' => 10,
        'status' => 'a',
        'fc'=>'FOTP',
        'stowage_plan'=>'68858',
        'cargo_suppl'=>0,
        'cargo_on_board'=>0,
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
        'destination'=>' ',
        'status_shipment'=>'completed'


      ]);

      Shipment::create([
        'id' => 2,
        'contract_id' => 2,
        'supplier_id' => 5,
        'customer_id' => 2,
        'product_id' => 3,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP002',
        'vessel' => 'Kapolei',
        'laycan_start' => '2017-01-16',
        'laycan_end' => '2017-03-12',
        'eta' => '2017-03-02',
        'etd' => '2017-03-13',
        'volume' => 58302,
        'demurrage_rate' => 11087,
        'loading_rate' => 13423,
        'price' => 11,
        'status' => 'a',
        'fc'=>'FOTP',
        'stowage_plan'=>'68858',
        'cargo_suppl'=>0,
        'cargo_on_board'=>0,
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
        'destination'=>' ',
        'status_shipment'=>'completed'
      ]);

      Shipment::create([
        'id' => 3,
        'contract_id' => 3,
        'supplier_id' => 4,
        'customer_id' => 1,
        'product_id' => 2,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP003',
        'vessel' => 'Pukekohe',
        'laycan_start' => '2017-07-23',
        'laycan_end' => '2017-08-02',
        'eta' => '2017-01-17',
        'etd' => '2017-01-21',
        'volume' => 71991,
        'demurrage_rate' => 14499,
        'loading_rate' => 15851,
        'price' => 16,
        'status' => 'a',
        'fc'=>'FOTP',
        'stowage_plan'=>'68858',
        'cargo_suppl'=>0,
        'cargo_on_board'=>0,
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
        'destination'=>' ',
        'status_shipment'=>'completed'
      ]);

      Shipment::create([
        'id' => 4,
        'contract_id' => 1,
        'supplier_id' => 4,
        'customer_id' => 1,
        'product_id' => 1,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP004',
        'vessel' => 'Pukekohe',
        'laycan_start' => '2017-02-25',
        'laycan_end' => '2017-03-01',
        'eta' => '2017-01-17',
        'etd' => '2017-01-21',
        'volume' => 61325,
        'demurrage_rate' => 13529,
        'loading_rate' => 10293,
        'price' => 13,
        'status' => 'a',
        'fc'=>'FOTP',
        'stowage_plan'=>'68858',
        'cargo_suppl'=>0,
        'cargo_on_board'=>0,
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
        'destination'=>' ',
        'status_shipment'=>'completed'
      ]);

      Shipment::create([
        'id' => 5,
        'contract_id' => 1,
        'supplier_id' => 4,
        'customer_id' => 1,
        'product_id' => 1,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP005',
        'vessel' => 'Lithgow',
        'laycan_start' => '2017-01-02',
        'laycan_end' => '2017-01-15',
        'eta' => '2017-01-17',
        'etd' => '2017-01-21',
        'volume' => 61325,
        'demurrage_rate' => 13529,
        'loading_rate' => 10293,
        'price' => 13,
        'status' => 'a',
        'fc'=>'FOTP',
        'stowage_plan'=>'68858',
        'cargo_suppl'=>0,
        'cargo_on_board'=>0,
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
        'destination'=>' ',
        'status_shipment'=>'completed'
      ]);

      Shipment::create([
        'id' => 6,
        'contract_id' => 1,
        'supplier_id' => 4,
        'customer_id' => 1,
        'product_id' => 1,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP006',
        'vessel' => 'Lithgow',
        'laycan_start' => '2017-01-25',
        'laycan_end' => '2017-01-31',
        'eta' => '2017-01-27',
        'etd' => '2017-01-31',
        'volume' => 61005,
        'demurrage_rate' => 13529,
        'loading_rate' => 10293,
        'price' => 13,
        'status' => 'a',
        'fc'=>'FOTP',
        'stowage_plan'=>'68858',
        'cargo_suppl'=>0,
        'cargo_on_board'=>0,
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
        'destination'=>' ',
        'status_shipment'=>'completed'
      ]);

      Shipment::create([
        'id' => 7,
        'contract_id' => 2,
        'supplier_id' => 5,
        'customer_id' => 2,
        'product_id' => 3,
        'surveyor_id' => 3,
        'shipment_no' => 'SHP007',
        'vessel' => 'Kapolei',
        'laycan_start' => '2017-03-02',
        'laycan_end' => '2017-03-15',
        'eta' => '2017-03-17',
        'etd' => '2017-03-21',
        'volume' => 73315,
        'demurrage_rate' => 13529,
        'loading_rate' => 10293,
        'price' => 13,
        'status' => 'a',
        'fc'=>'FOTP',
        'stowage_plan'=>'68858',
        'cargo_suppl'=>0,
        'cargo_on_board'=>0,
        'bl_date'=>'2016-07-22',
        'cargo_bl'=>68858,
        'destination'=>' ',
        'status_shipment'=>'completed'
      ]);
    }
}
