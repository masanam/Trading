<?php

use Illuminate\Database\Seeder;
use App\Model\Iup;

class IupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Iup::create([
            'id'=> '12947812382132',
            'company_id'=> 1,
            'concession_id'=> 1,
            'contact_id'=> 1,
            'source' => 'Other',
            'type'=>'XPLT',
            'expired' => '2018-1-2',
            'total_area' => 200,
            'overlap_other'=>'No',
            'reason_overlap_other' => Null ,
            'release_after' => 'Yes',
            'reason_release_after'=> Null,
            'already_production'=> 'No',
            'reason_already_production'=> Null,
            'restricted_area' => 'APL',
            'description'=> '75% APL, 25% H.Produksi',
            'overlap_smg' => 'No',
            'reason_overlap_smg'=> null,
            'produce_kp' => 'No' ,
            'reason_produce_kp' => null ,
            'land_use' => 'Overlap dengan area konsesi VICO Indonesia',
            'pit_to_port' => 12 ,
            'port_to_sea' => 5 ,
            'river' => 'S. Mahakam' ,
            'location' => 'Kalimantan',
			'coal_bearing_formation' => 'APL',
			'geological_description' => '75% APL, 25% H.Produksi',
			'geological_quality' => 'Good',
			'geological_cv' => 1928,
			'geological_tm' => 30,
			'geological_ts' => 20,
			'geological_ash' => 10,
			'geological_reserve' => 'Yes',
			'notes' => 'orem ipsum dolor sit amet, consectetur adipiscing elit. Proin arcu purus, auctor nec urna at, aliquam consectetur neque. Nunc eget maximus sapien. Integer eget luctus purus. Mauris lacinia vehicula arcu, sit amet pretium massa varius luctus. Nulla in congue ligula, at aliquet libero. Nullam et tincidunt dui. Nulla non congue ',
            'status' => 'a'
        ]);
    }
}
