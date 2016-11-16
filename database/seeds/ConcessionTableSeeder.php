<?php

use Illuminate\Database\Seeder;
use App\Model\Concession;

class ConcessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $concessions = [
            [
                'id' => 1,
                'concession_name' => 'Indexim',
                'seller_id' => 1,
                'owner' => 'Indexim',
                'address' => '',
                'city' => 'Kutai Timur',
                'country' => 'Indonesia',
                'latitude' => 1,
                'longitude' => 117,
                'polygon' => '[[1.2128916667,117.5587638889],[1.2300333333,117.5587638889],[1.2300333333,117.5945972222],[1.2870583333,117.5945972222],[1.2870583333,117.6037638889],[1.3598833333,117.6037638889],[1.3598833333,117.7050972222],[1.2961444444,117.7050972222],[1.2961444444,117.6620833333],[1.2658666667,117.6620833333],[1.2658666667,117.6781944444],[1.2300333333,117.6781944444],[1.2300333333,117.7140277778],[0.9833333333,117.7140277778],[0.9833333333,117.6037527778],[1.0508666667,117.6037527778],[1.0508666667,117.6172222222],[1.0867,117.6172222222],[1.0867,117.6432083333],[1.1225333333,117.6432083333],[1.1225333333,117.6037611111],[1.2128916667,117.6037611111],[1.2128916667,117.5587638889]]',
                'size' => NULL,
                'stripping_ratio' => NULL,
                'resource' => NULL,
                'reserves' => NULL,
                'contracted_volume' => NULL,
                'remaining_volume' => NULL,
                'annual_production' => NULL,
                'hauling_road_name' => NULL,
                'stockpile_capacity' => NULL,
                'stockpile_coverage' => NULL,
                'stockpile_distance' => NULL,
                'port_id' => NULL,
                'port_distance' => NULL,
                'license_type' => NULL,
                'license_expiry_date' => NULL,
                'status' => NULL
            ],
            [
                'id' => 2,
                'concession_name' => 'PT Berau Coal Energy',
                'seller_id' => 2,
                'owner' => 'PT Berau Coal Energy',
                'address' => '',
                'city' => 'Berau',
                'country' => 'Indonesia',
                'latitude' => 1,
                'longitude' => 117,
                'polygon' => '[[1.9075541362095692,117.14453911641658],[1.9625824848819775,117.14453911641658],[1.9625824848819775,117.13078202924851],[2.042697286625355,117.13078202924851],[2.042697286625355,117.16800708864457],[2.117956645839115,117.16800708864457],[2.117956645839115,117.24326644785833],[2.0540266525285915,117.24326644785833],[2.0540266525285915,117.201995186354],[2.032177161144034,117.201995186354],[2.032177161144034,117.17043480990947],[2.0006167846995027,117.17043480990947],[2.0006167846995027,117.17690873328286],[1.9925243804831325,117.17690873328286],[1.9925243804831325,117.21332455225718],[1.9998075442778145,117.21332455225718],[1.9998075442778145,117.26106973713468],[1.9536808402436918,117.26106973713468],[1.9536808402436918,117.31043340285544],[1.9998075442778145,117.31043340285544],[1.9998075442778145,117.33471061550483],[2.0184200739759603,117.33471061550483],[2.0184200739759603,117.39297592586377],[2.0362233632521907,117.39297592586377],[2.0362233632521907,117.41806237893502],[2.091251711924599,117.41806237893502],[2.091251711924599,117.42372706188655],[2.1009625969844024,117.42372706188655],[2.1009625969844024,117.42049010019991],[2.1066272799359353,117.42049010019991],[2.1066272799359353,117.41968085977828],[2.122002847947442,117.41968085977828],[2.122002847947442,117.4245363023083],[2.1163381649957387,117.4245363023083],[2.1163381649957387,117.43020098525994],[2.0985348757195084,117.43020098525994],[2.0985348757195084,117.44314883200639],[2.1357599351153453,117.44314883200639],[2.1357599351153453,117.45366895748771],[2.144661579753631,117.45366895748771],[2.144661579753631,117.48361085308898],[2.0799223460214193,117.48361085308898],[2.0799223460214193,117.47632768929395],[2.0265124781923305,117.47632768929395],[2.0265124781923305,117.45933364043924],[2.007899948494412,117.45933364043924],[2.007899948494412,117.44476731284954],[1.9714841295200927,117.44476731284954],[1.9714841295200927,117.35575086646793],[1.9374960318106673,117.35575086646793],[1.9374960318106673,117.33551985592658],[1.8913693277765447,117.33551985592658],[1.8913693277765447,117.29667631568736],[1.8727567980786262,117.29667631568736],[1.8727567980786262,117.23841100532832],[1.895415529884815,117.23841100532832],[1.895415529884815,117.21979847563023],[1.9075541362095692,117.21979847563023],[1.9075541362095692,117.14453911641658]]',
                'size' => NULL,
                'stripping_ratio' => NULL,
                'resource' => NULL,
                'reserves' => NULL,
                'contracted_volume' => NULL,
                'remaining_volume' => NULL,
                'annual_production' => NULL,
                'hauling_road_name' => NULL,
                'stockpile_capacity' => NULL,
                'stockpile_coverage' => NULL,
                'stockpile_distance' => NULL,
                'port_id' => NULL,
                'port_distance' => NULL,
                'license_type' => NULL,
                'license_expiry_date' => NULL,
                'status' => NULL
            ],
            [
                'id' => 3,
                'concession_name' => 'PT Berau Coal Energy',
                'seller_id' => 2,
                'owner' => 'PT Berau Coal Energy',
                'address' => '',
                'city' => 'Berau',
                'country' => 'Indonesia',
                'latitude' => 1,
                'longitude' => 117,
                'polygon' => '[[2.2611922004715552,117.51031578700338],[2.417375601850381,117.51031578700338],[2.417375601850381,117.58881210790355],[2.393098389200759,117.58881210790355],[2.393098389200759,117.61713552266144],[2.3469716851666362,117.61713552266144],[2.3469716851666362,117.62927412898614],[2.2943710577592924,117.62927412898614],[2.2943710577592924,117.64141273531106],[2.212637775172311,117.64141273531106],[2.212637775172311,117.62846488856462],[2.095297914032926,117.62846488856462],[2.095297914032926,117.52650059543635],[2.121193607525754,117.52650059543635],[2.121193607525754,117.5014141423652],[2.1357599351153453,117.5014141423652],[2.1357599351153453,117.50788806573848],[2.152753983970058,117.50788806573848],[2.152753983970058,117.46823528507753],[2.1640833498732945,117.46823528507753],[2.1640833498732945,117.46499832339089],[2.1729849945114097,117.46499832339089],[2.1729849945114097,117.45447819790934],[2.1697480328247707,117.45447819790934],[2.1697480328247707,117.44800427453617],[2.1665110711381885,117.44800427453617],[2.1665110711381885,117.44476731284954],[2.1616556286083437,117.44476731284954],[2.1616556286083437,117.43262870652484],[2.1576094265000734,117.43262870652484],[2.1576094265000734,117.41077921514011],[2.1543724648134344,117.41077921514011],[2.1543724648134344,117.39459440670714],[2.165701830716671,117.39459440670714],[2.165701830716671,117.28210998809755],[2.1915975242094987,117.28210998809755],[2.1915975242094987,117.25621429460466],[2.1665110711381885,117.25621429460466],[2.1665110711381885,117.20846910972716],[2.2498628345683755,117.20846910972716],[2.2498628345683755,117.33471061550483],[2.1956437263175985,117.33471061550483],[2.1956437263175985,117.36141554941935],[2.3065096640839897,117.36141554941935],[2.3065096640839897,117.38650200249072],[2.334023838420194,117.38650200249072],[2.334023838420194,117.40430529176695],[2.2223486602321145,117.40430529176695],[2.2223486602321145,117.42939174483809],[2.248244353725113,117.42939174483809],[2.248244353725113,117.47309072760731],[2.1907882837878105,117.47309072760731],[2.1907882837878105,117.57019957820557],[2.2312503048704,117.57019957820557],[2.2312503048704,117.54349464429106],[2.2611922004715552,117.54349464429106],[2.2611922004715552,117.51031578700338]]',
                'size' => NULL,
                'stripping_ratio' => NULL,
                'resource' => NULL,
                'reserves' => NULL,
                'contracted_volume' => NULL,
                'remaining_volume' => NULL,
                'annual_production' => NULL,
                'hauling_road_name' => NULL,
                'stockpile_capacity' => NULL,
                'stockpile_coverage' => NULL,
                'stockpile_distance' => NULL,
                'port_id' => NULL,
                'port_distance' => NULL,
                'license_type' => NULL,
                'license_expiry_date' => NULL,
                'status' => NULL
            ],
            [
                'id' => 4,
                'concession_name' => 'Borneo Indobara',
                'seller_id' => 3,
                'owner' => 'Borneo Indobara',
                'address' => '',
                'city' => 'Angsana',
                'country' => 'Indonesia',
                'latitude' => -3,
                'longitude' => 115,
                'polygon' => '[[-3.615,115.473831],[-3.575361,115.473831],[-3.575361,115.472778],[-3.575333,115.472778],[-3.575325,115.466667],[-3.575325,115.462502],[-3.575325,115.43222],[-3.56325,115.43222],[-3.56325,115.442497],[-3.550194,115.442497],[-3.550194,115.466805],[-3.518139,115.466805],[-3.518139,115.496582],[-3.500083,115.496582],[-3.500083,115.51461],[-3.468333,115.51461],[-3.468333,115.514641],[-3.467917,115.514641],[-3.467917,115.517914],[-3.463917,115.517914],[-3.463917,115.523666],[-3.454889,115.523666],[-3.454889,115.529442],[-3.454889,115.532669],[-3.45,115.532669],[-3.45,115.550003],[-3.449722,115.550003],[-3.449722,115.550056],[-3.437361,115.550056],[-3.437361,115.559692],[-3.431944,115.559692],[-3.431944,115.577698],[-3.445917,115.577698],[-3.445917,115.568695],[-3.454917,115.568695],[-3.454917,115.550667],[-3.463944,115.550667],[-3.463944,115.532669],[-3.472972,115.532669],[-3.472972,115.555138],[-3.464,115.555138],[-3.464,115.568665],[-3.473028,115.568665],[-3.473028,115.658302],[-3.717222,115.658302],[-3.717222,115.617775],[-3.699278,115.617775],[-3.699278,115.649307],[-3.685694,115.649307],[-3.685694,115.617363],[-3.663056,115.617363],[-3.663056,115.649361],[-3.608833,115.649361],[-3.608833,115.614998],[-3.608833,115.604446],[-3.545444,115.604446],[-3.545444,115.613525],[-3.529167,115.613525],[-3.518333,115.613525],[-3.518333,115.604584],[-3.509278,115.604584],[-3.509278,115.577583],[-3.500194,115.577583],[-3.500194,115.54158],[-3.509167,115.54158],[-3.509167,115.532585],[-3.518194,115.532585],[-3.518194,115.529442],[-3.518194,115.51458],[-3.53625,115.51458],[-3.53625,115.50103],[-3.545278,115.50103],[-3.545278,115.487389],[-3.615,115.487389],[-3.635694,115.487389],[-3.635694,115.505249],[-3.717083,115.505249],[-3.717083,115.481667],[-3.706432,115.481667],[-3.706432,115.481636],[-3.706432,115.481613],[-3.706306,115.481613],[-3.706306,115.473747],[-3.698972,115.473747],[-3.698972,115.478279],[-3.698917,115.478279],[-3.679278,115.478279],[-3.667333,115.478279],[-3.667333,115.474197],[-3.667333,115.473831],[-3.615,115.473831]]',
                'size' => NULL,
                'stripping_ratio' => NULL,
                'resource' => NULL,
                'reserves' => NULL,
                'contracted_volume' => NULL,
                'remaining_volume' => NULL,
                'annual_production' => NULL,
                'hauling_road_name' => NULL,
                'stockpile_capacity' => NULL,
                'stockpile_coverage' => NULL,
                'stockpile_distance' => NULL,
                'port_id' => NULL,
                'port_distance' => NULL,
                'license_type' => NULL,
                'license_expiry_date' => NULL,
                'status' => NULL
            ],
            [
                'id' => 5,
                'concession_name' => 'PT. Jembayan Muara Bara',
                'seller_id' => 4,
                'owner' => 'Tiger Energy',
                'address' => '',
                'city' => 'Kutai Kertanegara',
                'country' => 'Indonesia',
                'latitude' => 0,
                'longitude' => 117,
                'polygon' => '[[-0.16737476798124362,117.14378841811163],[-0.1718984100899661,117.14378845149827],[-0.1718984243580053,117.14188494348036],[-0.1718984436174651,117.13929507144508],[-0.1718986485072378,117.10784138848203],[-0.16285135172040555,117.10784133906964],[-0.16285130130319203,117.11682810526895],[-0.156610102905006,117.11682807233421],[-0.15514972202487343,117.11680740762836],[-0.1551298735923865,117.11682806361796],[-0.1479803957574859,117.11682802554833],[-0.1357094188741712,117.11682796204059],[-0.13570938426977364,117.12370311375514],[-0.13570937349874157,117.12581471432884],[-0.12987077273834302,117.12581468501901],[-0.1266620822387381,117.12581466914583],[-0.12666207719513523,117.12682575846316],[-0.12666204743840126,117.13271000548559],[-0.12666203675138377,117.13480141509069],[-0.1250712104762215,117.13480140708009],[-0.11761474867694233,117.13480137001909],[-0.11761471569309379,117.14138714790352],[-0.11761470352575998,117.14378810962046],[-0.11761452817989948,117.17083578256086],[-0.11761423744979993,117.2156818795313],[-0.14475598350179553,117.21568211189935],[-0.1447562255025332,117.18872195308052],[-0.1628507527656211,117.1887221119996],[-0.1628508354494329,117.17973537518094],[-0.16737446951242418,117.17973541580102],[-0.16737452117200746,117.173768913358],[-0.16737476798124362,117.14378841811163]]',
                'size' => NULL,
                'stripping_ratio' => NULL,
                'resource' => NULL,
                'reserves' => NULL,
                'contracted_volume' => NULL,
                'remaining_volume' => NULL,
                'annual_production' => NULL,
                'hauling_road_name' => NULL,
                'stockpile_capacity' => NULL,
                'stockpile_coverage' => NULL,
                'stockpile_distance' => NULL,
                'port_id' => NULL,
                'port_distance' => NULL,
                'license_type' => NULL,
                'license_expiry_date' => NULL,
                'status' => NULL
            ],
        ];
        
        foreach($concessions as $concession)
            Concession::create([
                'id' => $concession->id
                'concession_name' => $concession->concession_name
                'seller_id' => $concession->seller_id
                'owner' => $concession->owner
                'address' => $concession->address
                'city' => $concession->city
                'country' => $concession->country
                'latitude' => $concession->latitude
                'longitude' => $concession->longitude
                'polygon' => $concession->polygon
                'size' => $concession->size
                'stripping_ratio' => $concession->stripping_ratio
                'resource' => $concession->resource
                'reserves' => $concession->reserves
                'contracted_volume' => $concession->contracted_volume
                'remaining_volume' => $concession->remaining_volume
                'annual_production' => $concession->annual_production
                'hauling_road_name' => $concession->hauling_road_name
                'stockpile_capacity' => $concession->stockpile_capacity
                'stockpile_coverage' => $concession->stockpile_coverage
                'stockpile_distance' => $concession->stockpile_distance
                'port_id' => $concession->port_id
                'port_distance' => $concession->port_distance
                'license_type' => $concession->license_type
                'license_expiry_date' => $concession->license_expiry_date
                'status' => $concession->status
                'created_at' => $concession->created_at
                'updated_at' => $concession->updated_at
            ]);


        // Concession::create([
        //     'concession_name'=> 'KIM East',
        //     'owner'=> 'East',
        // 	'seller_id' => '1',
        //     'city'=>'Jakarta',
        //     'country' => 'ID',
        //     'polygon' => '',
        //     'address'=>'Jl. Raya Slipi Kemangisan',
        //     'latitude' => 2.2 ,
        //     'longitude' => 115.2 ,
        //     'size'=>'10',
        //     'resource'=> 1680,
        //     'reserves'=> 1680,
        //     'remaining_volume' => 1000,
        //     'contracted_volume'=> 10,
        //     'annual_production' => 10,
        //     'stockpile_distance'=> 100,
        //     'stripping_ratio' => 10.7 ,
        //     'stockpile_capacity' => 11 ,
        //     'port_distance' => 262,
        //     'stockpile_coverage' => 30 ,
        //     'port_id' => 1 ,
        //     // 'river_capacity' => '' ,
        //     'license_type' => 'IUP' ,
        //     'license_expiry_date' => '2022-04-05' ,
        //     'status' => 'a'
        // ]);
        
        // Concession::create([
        //     'concession_name'=> 'KIM East 2',
        //     'owner'=> 'East 2',
        //     'seller_id' => '1',
        //     'city'=>'Jakarta',
        //     'country' => 'ID',
        //     'polygon' => '',
        //     'address'=>'Jl. Raya Bekasi',
        //     'latitude' => 1.30 ,
        //     'longitude' => 113.4 ,
        //     'size'=>'10',
        //     'resource'=> 1690,
        //     'reserves'=> 1690,
        //     'remaining_volume' => 1000,
        //     'contracted_volume'=> 20,
        //     'annual_production' => 20,
        //     'stockpile_distance'=> 200,
        //     'stripping_ratio' => 10.7 ,
        //     'stockpile_capacity' => 11 ,
        //     'port_distance' => 300,
        //     'stockpile_coverage' => 40 ,
        //     'port_id' => 1 ,
        //     // 'river_capacity' => '' ,
        //     'license_type' => 'IUP' ,
        //     'license_expiry_date' => '2022-04-05' ,
        //     'status' => 'a'
        // ]);

        // Concession::create([
        //     'concession_name'=> 'BIB BS, SS, NSN BLOCK',
        //     'owner'=> 'East',
        //     'seller_id' => '1',
        //     'city'=>'Jakarta',
        //     'country' => 'ID',
        //     'polygon' => '',
        //     'address'=>'Jl. Raya Slipi Kemangisan',
        //     'latitude' => 1.4 ,
        //     'longitude' => 115.8 ,
        //     'size'=>'10',
        //     'resource'=> 1680,
        //     'reserves'=> 1680,
        //     'remaining_volume' => 1000,
        //     'contracted_volume'=> 10,
        //     'annual_production' => 10,
        //     'stockpile_distance'=> 100,
        //     'stripping_ratio' => 10.7 ,
        //     'stockpile_capacity' => 11 ,
        //     'port_distance' => 262,
        //     'stockpile_coverage' => 30 ,
        //     'port_id' => 1 ,
        //     // 'river_capacity' => '' ,
        //     'license_type' => 'IUP' ,
        //     'license_expiry_date' => '2022-04-05' ,
        //     'status' => 'a'
        // ]);
        
        
        
    }
}
