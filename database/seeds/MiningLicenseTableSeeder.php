<?php

use Illuminate\Database\Seeder;
use App\Model\MiningLicense;


class MiningLicenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        MiningLicense::create([
            'no'=> '1012',
            'company_id'=> 1,
            'concession_id'=> 1,
            'contact_id'=> 1,
            'source' => 'Other',
            'type'=>'XPLT',
            'expired' => '2018-1-2',
            'total_area' => 200,
            'overlap_other'=> 0,
            'overlap_other_desc' => Null ,
            'release_after' => 1,
            'release_after_desc'=> Null,
            'already_production'=> 0,
            'already_production_desc'=> Null,
            'restricted_area' => 'APL',
            'description'=> '75% APL, 25% H.Produksi',
            'overlap_smg' => 0,
            'overlap_smg_desc'=> null,
            'produce_kp' => 0 ,
            'produce_kp_desc' => null ,
            'land_use' => 'Overlap dengan area konsesi VICO Indonesia',
            'location' => 'Kalimantan',
			'coal_bearing_formation' => 'APL',
			'geological_description' => '75% APL, 25% H.Produksi',
			'geological_quality' => 'Good',
			'geological_cv' => 1928,
			'geological_tm' => 30,
			'geological_ts' => 20,
			'geological_ash' => 10,
			'geological_reserve' => 1,
			'notes' => 'orem ipsum dolor sit amet, consectetur adipiscing elit. Proin arcu purus, auctor nec urna at, aliquam consectetur neque. Nunc eget maximus sapien. Integer eget luctus purus. Mauris lacinia vehicula arcu, sit amet pretium massa varius luctus. Nulla in congue ligula, at aliquet libero. Nullam et tincidunt dui. Nulla non congue ',
			'polygon' => DB::raw("GeomFromText('POLYGON((-0.16737476798124362 117.14378841811163, -0.1718984100899661 117.14378845149827, -0.1718984243580053 117.14188494348036, -0.1718984436174651 117.13929507144508, -0.1718986485072378 117.10784138848203, -0.16285135172040555 117.10784133906964, -0.16285130130319203 117.11682810526895, -0.156610102905006 117.11682807233421, -0.15514972202487343 117.11680740762836, -0.1551298735923865 117.11682806361796, -0.1479803957574859 117.11682802554833, -0.1357094188741712 117.11682796204059, -0.13570938426977364 117.12370311375514, -0.13570937349874157 117.12581471432884, -0.12987077273834302 117.12581468501901, -0.1266620822387381 117.12581466914583, -0.12666207719513523 117.12682575846316, -0.12666204743840126 117.13271000548559, -0.12666203675138377 117.13480141509069, -0.1250712104762215 117.13480140708009, -0.11761474867694233 117.13480137001909, -0.11761471569309379 117.14138714790352, -0.11761470352575998 117.14378810962046, -0.11761452817989948 117.17083578256086, -0.11761423744979993 117.2156818795313, -0.14475598350179553 117.21568211189935, -0.1447562255025332 117.18872195308052, -0.1628507527656211 117.1887221119996, -0.1628508354494329 117.17973537518094, -0.16737446951242418 117.17973541580102, -0.16737452117200746 117.173768913358, -0.16737476798124362 117.14378841811163))')"),
            'status' => 'a',
            'checked_by' => 3,
            'checked_at' => '2017-01-13',
            'is_corrupt' => 0,
            'is_operating' => 1,
            'close_to_sinarmas_factory' => 1,
            'close_to_sinarmas_concession' => 0,
            'close_to_river' => 1,
            'close_to_other_concession' => 1,
            'is_mining_zone' => 1,
            'is_settlement_zone' => 0,
            'is_palm_plantation' => 1,
            'is_farming_zone' => 0,
            'is_sinarmas_forestry' => 1
        ]);

        MiningLicense::create([
            'no'=> '1034',
            'company_id'=> 2,
            'concession_id'=> 2,
            'contact_id'=> 1,
            'source' => 'Other',
            'type'=>'XPLT',
            'expired' => '2018-1-2',
            'total_area' => 300,
            'overlap_other'=> 0,
            'overlap_other_desc' => Null ,
            'release_after' => 1,
            'release_after_desc'=> Null,
            'already_production'=> 0,
            'already_production_desc'=> Null,
            'restricted_area' => 'APL',
            'description'=> '25% APL, 35% H.Produksi',
            'overlap_smg' => 0,
            'overlap_smg_desc'=> null,
            'produce_kp' => 0 ,
            'produce_kp_desc' => null ,
            'land_use' => 'Overlap dengan area konsesi VICO Indonesia',
            'location' => 'Kalimantan',
            'coal_bearing_formation' => 'APL',
            'geological_description' => '75% APL, 25% H.Produksi',
            'geological_quality' => 'Good',
            'geological_cv' => 1928,
            'geological_tm' => 30,
            'geological_ts' => 20,
            'geological_ash' => 10,
            'geological_reserve' => 1,
            'notes' => 'Practcal 11 22 ',
            'polygon' => DB::raw("GeomFromText('POLYGON((25.774252 -80.190262,18.466465 -66.118292, 32.321384 -64.75737, 25.774252 -80.190262))')"),
            'status' => 'd',
            'checked_by' => 1,
            'checked_at' => '2017-01-5'
        ]);

        MiningLicense::create([
            'no'=> '1044',
            'company_id'=> 3,
            'concession_id'=> 3,
            'contact_id'=> 1,
            'source' => 'Internal',
            'type'=>'XPLT',
            'expired' => '2018-1-2',
            'total_area' => 400,
            'overlap_other'=> 0,
            'overlap_other_desc' => Null ,
            'release_after' => 1,
            'release_after_desc'=> Null,
            'already_production'=> 0,
            'already_production_desc'=> Null,
            'restricted_area' => 'APL',
            'description'=> '25% APL, 35% H.Produksi',
            'overlap_smg' => 0,
            'overlap_smg_desc'=> null,
            'produce_kp' => 0 ,
            'produce_kp_desc' => null ,
            'land_use' => 'Overlap dengan area konsesi VICO Indonesia',
            'location' => 'Kalimantan',
            'coal_bearing_formation' => 'APL',
            'geological_description' => '75% APL, 25% H.Produksi',
            'geological_quality' => 'Good',
            'geological_cv' => 1928,
            'geological_tm' => 30,
            'geological_ts' => 20,
            'geological_ash' => 10,
            'geological_reserve' => 1,
            'notes' => 'Practcal 33 22 ',
            'polygon' => DB::raw("GeomFromText('POLYGON((-0.1 118, -0.8718984100899661 118.14378845149827, -1.8718984100899661 118.14378845149827, -0.1 118))')"),
            'status' => 'p',
            'checked_by' => 1,
            'checked_at' => '2017-01-7'
        ]);
    }
}