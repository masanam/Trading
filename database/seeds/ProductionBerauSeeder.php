<?php

use App\Model\User;
use App\Model\Role;
use App\Model\Privilege;

use Illuminate\Database\Seeder;

class ProductionBerauSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
  	/*
  	 * USER SEEDER
  	 */

    $users = [
    	[ 'id' => 1, 'name' => 'Prasetyo Nugraha Gema', 'email' => 'pras@volantech.io', 'title' => 'Admin', 'image' => './images/default.png', 'phone'=> '+6281517051234', 'employee_no'=>'VTI1', 'manager_id'=>null],
      [ 'id' => 2, 'name' => 'Yudhi Saputra Intan', 'email' => 'yudhi.saputra@beraucoal.co.id', 'title' => 'Marketing & Sales Adm. Superintendence', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>4],
      [ 'id' => 3, 'name' => 'Rory Surya Perdana', 'email' => 'rori@beraucoal.co.id', 'title' => 'Marketing Researcher Sr. Specialist', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>4],
      [ 'id' => 4, 'name' => 'Supandri Yaman', 'email' => 'andri@beraucoal.co.id', 'title' => 'Dept. Head Marketing & Sales Adm. Supp.', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>null],
      [ 'id' => 5, 'name' => 'Andry Octavianus', 'email' => 'andri.o@beraucoal.co.id', 'title' => 'Sales Specialist Area 3', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>null],
    ];

    foreach($users as $user){
      User::create([
        'name' => $user['name'],
        'title' => $user['title'],
        'image' => $user['image'],
        'email' => $user['email'],
        'phone' => $user['phone'],
        'manager_id' => $user['manager_id'],
        'password' => bcrypt('secret'),
        'status' => 'a'
      ]);
    }

    Privilege::create([ 'id' => 1, 'menu' => 'order.view' ]);
    Privilege::create([ 'id' => 2, 'menu' => 'order.edit' ]);
    Privilege::create([ 'id' => 3, 'menu' => 'order.approval' ]);
    Privilege::create([ 'id' => 4, 'menu' => 'lead.view' ]);
    Privilege::create([ 'id' => 5, 'menu' => 'lead.edit' ]);
    Privilege::create([ 'id' => 6, 'menu' => 'index.view' ]);
    Privilege::create([ 'id' => 7, 'menu' => 'index.edit' ]);
    Privilege::create([ 'id' => 8, 'menu' => 'coalpedia.view' ]);
    Privilege::create([ 'id' => 9, 'menu' => 'coalpedia.edit' ]);

    Role::create(['id' => 1,    'role' => 'root']);
    Role::create(['id' => 2,    'role' => 'admin']);
    Role::create(['id' => 3,   'role' => 'sales']);
    Role::create(['id' => 4,   'role' => 'intel']);
    Role::create(['id' => 5,   'role' => 'msd-area-1']);
    Role::create(['id' => 6,   'role' => 'msd-area-2']);
    Role::create(['id' => 7,   'role' => 'msd-area-3']);
    Role::create(['id' => 8,   'role' => 'msd-area-4']);
    Role::create(['id' => 9,   'role' => 'general-manager']);
    Role::create(['id' => 10,   'role' => 'cmo']);
    Role::create(['id' => 11,   'role' => 'bc1']);

    User::find(1)->roles()->attach([1, 2]); // Pras
    User::find(2)->roles()->attach([1, 2]); // Yudhi
    User::find(3)->roles()->attach([3, 4]); // Rory
    User::find(4)->roles()->attach([3]); // Supandri
    User::find(5)->roles()->attach([3]); // Sales


    Role::find(3)->privileges()->attach(2); // sales
    Role::find(3)->privileges()->attach(5);
    Role::find(3)->privileges()->attach(9);

    Role::find(4)->privileges()->attach(6); // intel
    Role::find(4)->privileges()->attach(7);

    Role::find(5)->privileges()->attach(3); // msd-area-1
    Role::find(6)->privileges()->attach(3); // msd-area-2
    Role::find(7)->privileges()->attach(3); // msd-area-3
    Role::find(8)->privileges()->attach(3); // msd-area-4
    Role::find(9)->privileges()->attach(3); // general-manager
    Role::find(10)->privileges()->attach(3); // cmo
    Role::find(11)->privileges()->attach(3); // bc1


    Area::create(['id' => 1, 'area_name' => 'Area 1', 'description' => 'Area 1', 'status' => 'a']);
    Area::create(['id' => 2, 'area_name' => 'Area 2', 'description' => 'Area 2', 'status' => 'a']);
    Area::create(['id' => 3, 'area_name' => 'Area 3', 'description' => 'Area 3', 'status' => 'a']);
    Area::create(['id' => 4, 'area_name' => 'Area 4', 'description' => 'Area 4', 'status' => 'a']);


  	/*
  	 * APPROVAL SCHEME SEEDER
  	 */




  	/*
  	 * COMPANY SEEDER
  	 */

    Company::create([
      'company_name' => 'Berau Coal, PT',
      'user_id' => '1',
      'area_id' =>  2,
      'phone' => '021 29669700',
      'is_affiliated'=>'1',
      'annual_sales'=>'0',
      'preferred_trading_term'=>'FOB MV',
      'preferred_payment_term'=> 'LC',
      'purchasing_countries'=>'',
      'email' => '',
      'web' => '',
      'country'=> 'ID',
      'industry' => 'Coal Mining',
      'city' => 'Kalimantan Timur',
      'address' =>'Menara Sunlife 17th Floor, Jl. Dr. Ide Anak Agung Gede Blok 63, South Jakarta 12950',
      'description' => '',
      'company_type' => 's',
      'purchasing_countries' => 'ID',
      'status' => 'a'
    ]);

  	/*
  	 * CONCESSION SEEDER
  	 */

  	Concession::create([
      'id' => 2,
      'concession_name' => 'PT Berau Coal Energy',
      'company_id' => 5,
      'owner' => 'PT Berau Coal Energy',
      'address' => '',
      'city' => 'Berau',
      'country' => 'Indonesia',
      'latitude' => 1,
      'longitude' => 117,
      'polygon' => DB::raw("GeomFromText('POLYGON((1.9075541362095692 117.14453911641658, 1.9625824848819775 117.14453911641658, 1.9625824848819775 117.13078202924851, 2.042697286625355 117.13078202924851, 2.042697286625355 117.16800708864457, 2.117956645839115 117.16800708864457, 2.117956645839115 117.24326644785833, 2.0540266525285915 117.24326644785833, 2.0540266525285915 117.201995186354, 2.032177161144034 117.201995186354, 2.032177161144034 117.17043480990947, 2.0006167846995027 117.17043480990947, 2.0006167846995027 117.17690873328286, 1.9925243804831325 117.17690873328286, 1.9925243804831325 117.21332455225718, 1.9998075442778145 117.21332455225718, 1.9998075442778145 117.26106973713468, 1.9536808402436918 117.26106973713468, 1.9536808402436918 117.31043340285544, 1.9998075442778145 117.31043340285544, 1.9998075442778145 117.33471061550483, 2.0184200739759603 117.33471061550483, 2.0184200739759603 117.39297592586377, 2.0362233632521907 117.39297592586377, 2.0362233632521907 117.41806237893502, 2.091251711924599 117.41806237893502, 2.091251711924599 117.42372706188655, 2.1009625969844024 117.42372706188655, 2.1009625969844024 117.42049010019991, 2.1066272799359353 117.42049010019991, 2.1066272799359353 117.41968085977828, 2.122002847947442 117.41968085977828, 2.122002847947442 117.4245363023083, 2.1163381649957387 117.4245363023083, 2.1163381649957387 117.43020098525994, 2.0985348757195084 117.43020098525994, 2.0985348757195084 117.44314883200639, 2.1357599351153453 117.44314883200639, 2.1357599351153453 117.45366895748771, 2.144661579753631 117.45366895748771, 2.144661579753631 117.48361085308898, 2.0799223460214193 117.48361085308898, 2.0799223460214193 117.47632768929395, 2.0265124781923305 117.47632768929395, 2.0265124781923305 117.45933364043924, 2.007899948494412 117.45933364043924, 2.007899948494412 117.44476731284954, 1.9714841295200927 117.44476731284954, 1.9714841295200927 117.35575086646793, 1.9374960318106673 117.35575086646793, 1.9374960318106673 117.33551985592658, 1.8913693277765447 117.33551985592658, 1.8913693277765447 117.29667631568736, 1.8727567980786262 117.29667631568736, 1.8727567980786262 117.23841100532832, 1.895415529884815 117.23841100532832, 1.895415529884815 117.21979847563023, 1.9075541362095692 117.21979847563023, 1.9075541362095692 117.14453911641658))')"),
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
      'port_id' => 2,
      'port_distance' => 15,
      'license_type' => NULL,
      'license_expiry_date' => NULL,
      'status' => 'a'
  ]);
  
  Concession::create([
      'id' => 3,
      'concession_name' => 'PT Berau Coal Energy',
      'company_id' => 5,
      'owner' => 'PT Berau Coal Energy',
      'address' => '',
      'city' => 'Berau',
      'country' => 'Indonesia',
      'latitude' => 1,
      'longitude' => 117,
      'polygon' => DB::raw("GeomFromText('POLYGON((2.2611922004715552 117.51031578700338, 2.417375601850381 117.51031578700338, 2.417375601850381 117.58881210790355, 2.393098389200759 117.58881210790355, 2.393098389200759 117.61713552266144, 2.3469716851666362 117.61713552266144, 2.3469716851666362 117.62927412898614, 2.2943710577592924 117.62927412898614, 2.2943710577592924 117.64141273531106, 2.212637775172311 117.64141273531106, 2.212637775172311 117.62846488856462, 2.095297914032926 117.62846488856462, 2.095297914032926 117.52650059543635, 2.121193607525754 117.52650059543635, 2.121193607525754 117.5014141423652, 2.1357599351153453 117.5014141423652, 2.1357599351153453 117.50788806573848, 2.152753983970058 117.50788806573848, 2.152753983970058 117.46823528507753, 2.1640833498732945 117.46823528507753, 2.1640833498732945 117.46499832339089, 2.1729849945114097 117.46499832339089, 2.1729849945114097 117.45447819790934, 2.1697480328247707 117.45447819790934, 2.1697480328247707 117.44800427453617, 2.1665110711381885 117.44800427453617, 2.1665110711381885 117.44476731284954, 2.1616556286083437 117.44476731284954, 2.1616556286083437 117.43262870652484, 2.1576094265000734 117.43262870652484, 2.1576094265000734 117.41077921514011, 2.1543724648134344 117.41077921514011, 2.1543724648134344 117.39459440670714, 2.165701830716671 117.39459440670714, 2.165701830716671 117.28210998809755, 2.1915975242094987 117.28210998809755, 2.1915975242094987 117.25621429460466, 2.1665110711381885 117.25621429460466, 2.1665110711381885 117.20846910972716, 2.2498628345683755 117.20846910972716, 2.2498628345683755 117.33471061550483, 2.1956437263175985 117.33471061550483, 2.1956437263175985 117.36141554941935, 2.3065096640839897 117.36141554941935, 2.3065096640839897 117.38650200249072, 2.334023838420194 117.38650200249072, 2.334023838420194 117.40430529176695, 2.2223486602321145 117.40430529176695, 2.2223486602321145 117.42939174483809, 2.248244353725113 117.42939174483809, 2.248244353725113 117.47309072760731, 2.1907882837878105 117.47309072760731, 2.1907882837878105 117.57019957820557, 2.2312503048704 117.57019957820557, 2.2312503048704 117.54349464429106, 2.2611922004715552 117.54349464429106, 2.2611922004715552 117.51031578700338))')"),
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
      'port_id' => 2,
      'port_distance' => NULL,
      'license_type' => NULL,
      'license_expiry_date' => NULL,
      'status' => 'a'
  ]);

  	/*
  	 * PRODUCT SEEDER
  	 */

		Product::create(['company_id' => 1,'concession_id' => 1,'product_name' => 'Ebony HS','typical_quality' => 'GAR5500','tm_min' => '20','tm_max' => '14','im_min' =>'14','im_max' =>'0.9','ash_min' =>'5','ash_max' => '55','fc_min' => null,'fc_max' => null,'vm_min' => null,'vm_max' => null,'ts_min' => '0.9','ts_max' => '5','ncv_min' => '20','ncv_max' => '90','gcv_arb_min' => '5500','gcv_arb_max' => '5900','gcv_adb_min' => '5500','gcv_adb_max' => '5900','hgi_min' => '40','hgi_max' => null,'size_min' => null,'size_max' => null,'fe2o3_min'=> '5300','fe2o3_max'=> null,'aft_min'=> null,'aft_max'=>null,'na2o_min'=> null,'na2o_max'=>null,'status' => 'a']);
		Product::create(['company_id' => 1,'concession_id' => 1,'product_name' => 'Mahoni','typical_quality' => 'GAR5500','tm_min' => '20','tm_max' => '14','im_min' =>'14','im_max' =>'0.9','ash_min' =>'5','ash_max' => '55','fc_min' => null,'fc_max' => null,'vm_min' => null,'vm_max' => null,'ts_min' => '0.9','ts_max' => '5','ncv_min' => '20','ncv_max' => '90','gcv_arb_min' => '5500','gcv_arb_max' => '5900','gcv_adb_min' => '5500','gcv_adb_max' => '5900','hgi_min' => '40','hgi_max' => null,'size_min' => null,'size_max' => null,'fe2o3_min'=> '5300','fe2o3_max'=> null,'aft_min'=> null,'aft_max'=>null,'na2o_min'=> null,'na2o_max'=>null,'status' => 'a']);
    Product::create(['company_id' => 1,'concession_id' => 1,'product_name' => 'Mahoni B','typical_quality' => 'GAR5800','tm_min' => '22.5','tm_max' => '16','im_min' =>'16','im_max' =>'0.9','ash_min' =>'5','ash_max' => '55','fc_min' => null,'fc_max' => null,'vm_min' => null,'vm_max' => null,'ts_min' => '0.9','ts_max' => '5','ncv_min' => '22.5','ncv_max' => '5900','gcv_arb_min' => '5300','gcv_arb_max' => '5750','gcv_adb_min' => '5300','gcv_adb_max' => '5750','hgi_min' => '40','hgi_max' => null,'size_min' => null,'size_max' => null,'fe2o3_min'=> '50','fe2o3_max'=> null,'aft_min'=> null,'aft_max'=>null,'na2o_min'=> null,'na2o_max'=>null,'status' => 'a']);
    Product::create(['company_id' => 1,'concession_id' => 1,'product_name' => 'Sungkai','typical_quality' => 'NAR3200','tm_min' => '25','tm_max' => '28','im_min' =>'28','im_max' =>'1','ash_min' =>'5','ash_max' => '55','fc_min' => null,'fc_max' => null,'vm_min' => null,'vm_max' => null,'ts_min' => '1','ts_max' => '5','ncv_min' => '2500','ncv_max' => '90','gcv_arb_min' => '5000','gcv_arb_max' => '5500','gcv_adb_min' => '5000','gcv_adb_max' => '5500','hgi_min' => '40','hgi_max' => null,'size_min' => null,'size_max' => null,'fe2o3_min'=> '4600','fe2o3_max'=> null,'aft_min'=> null,'aft_max'=>null,'na2o_min'=> null,'na2o_max'=>null,'status' => 'a']);
//     '1','1',NULL,'Mahoni','GAR5500',NULL,'5500.00','5900.00','5500.00','5900.00','20.00','90.00','5.00','55.00','0.90','5.00','20.00','14.00','14.00','0.90',NULL,NULL,NULL,NULL,'40.00',NULL,NULL,NULL,'5300.00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2017-02-16 23:57:51','2017-02-16 23:57:51'
// '2','1',NULL,'Mahoni B','GAR5800',NULL,'5300.00','5750.00','5300.00','5750.00','23.00','5900.00','5.00','55.00','0.90','5.00','22.50','16.00','16.00','0.90',NULL,NULL,NULL,NULL,'40.00',NULL,NULL,NULL,'50.00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2017-02-16 23:57:51','2017-02-16 23:57:51'
// '3','1',NULL,'Agathis','NAR3200',NULL,'5000.00','5500.00','5000.00','5500.00','2500.00','90.00','5.00','55.00','1.00','5.00','25.00','28.00','28.00','1.00',NULL,NULL,NULL,NULL,'40.00',NULL,NULL,NULL,'4600.00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2017-02-16 23:57:51','2017-02-16 23:57:51'
// '4','1',NULL,'Ebony HS','GAR5500',NULL,NULL,'4200.00','4200.00','5500.00','5500.00','3800.00','6.00','6.00','0.30','0.30','37.00','37.00','15.00','15.00',NULL,NULL,'42.00',NULL,'55.00',NULL,'90.00',NULL,'20.00',NULL,'1150.00',NULL,NULL,NULL,NULL,NULL,'a','2017-02-16 23:57:51','2017-02-16 23:57:51'
// '5','1',NULL,'Sungkai','GAR5500',NULL,NULL,'5500.00','4200.00','5500.00','5500.00','3800.00','6.00','6.00','0.30','0.30','37.00','37.00','15.00','15.00',NULL,NULL,'42.00',NULL,'55.00',NULL,'90.00',NULL,'20.00',NULL,'1150.00',NULL,NULL,NULL,NULL,NULL,'a','2017-02-16 23:57:51','2017-02-16 23:57:51'
// '6','1',NULL,'Sungkai LS','GAR5500',NULL,NULL,'5500.00','4200.00','5500.00','5500.00','3800.00','6.00','6.00','0.30','0.30','37.00','37.00','15.00','15.00',NULL,NULL,'42.00',NULL,'55.00',NULL,'90.00',NULL,'20.00',NULL,'1150.00',NULL,NULL,NULL,NULL,NULL,'a','2017-02-16 23:57:51','2017-02-16 23:57:51'
// '7','1',NULL,'Sungkai MS','GAR5500',NULL,NULL,'5500.00','4200.00','5500.00','5500.00','3800.00','6.00','6.00','0.30','0.30','37.00','37.00','15.00','15.00',NULL,NULL,'42.00',NULL,'55.00',NULL,'90.00',NULL,'20.00',NULL,'1150.00',NULL,NULL,NULL,NULL,NULL,'a','2017-02-16 23:57:51','2017-02-16 23:57:51'
// '8','1',NULL,'Sungkai HS','GAR5500',NULL,NULL,'5500.00','4200.00','5500.00','5500.00','3800.00','6.00','6.00','0.30','0.30','37.00','37.00','15.00','15.00',NULL,NULL,'42.00',NULL,'55.00',NULL,'90.00',NULL,'20.00',NULL,'1150.00',NULL,NULL,NULL,NULL,NULL,'a','2017-02-16 23:57:51','2017-02-16 23:57:51'



  	/*
  	 * PORT SEEDER
  	 */

  	$model = Port::create([
      'port_name' => 'Berau Coal, PT', 'owner' => 'Kalimantan Timur', 'is_private' => 1, 'location' => 'Sungai Segah', 'size' => 0, 'river_capacity' => 0, 'latitude' => 2.156904, 'longitude' => 117.4911258, 'anchorage_distance' => 0, 'has_conveyor' => 0, 'has_crusher' => 0, 'has_blending' => 0, 'draft_height' => 0, 'river' => 'Riv', 'open_sea_distance' => 20,
      'daily_discharge_rate' => $faker->numberBetween($min = 1, $max = 55), 'status' => 'a'
    ]);
    if(isset($port['company'])) $model->companies()->attach(1);

    /*
     * INDEX SEEDER
     */

    Index::create(['id'=>1, 'index_provider' => 'HBA', 'index_name' => 'GAR 6322', 'quality' => 'GAR 6322', 'frequency'=>'d']);
		Index::create(['id'=>2, 'index_provider' => 'HBA*', 'index_name' => 'GAR 6322', 'quality' => 'GAR 6322', 'frequency'=>'d']);
		Index::create(['id'=>3, 'index_provider' => 'GCI NEW', 'index_name' => 'GAR 6322', 'quality' => 'GAR 6322', 'frequency'=>'d']);
		Index::create(['id'=>4, 'index_provider' => 'Coalfax Index', 'index_name' => 'GAR 6322', 'quality' => 'GAR 6322', 'frequency'=>'d']);
		Index::create(['id'=>5, 'index_provider' => 'ICI 1 Index', 'index_name' => 'GAR 6322', 'quality' => 'GAR 6322', 'frequency'=>'d']);
		Index::create(['id'=>6, 'index_provider' => 'Platts (FOB Kalimantan)', 'index_name' => 'GAR 6322', 'quality' => 'GAR 6322', 'frequency'=>'d']);
  }
}
