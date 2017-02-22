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


  	/*
  	 * COMPANY SEEDER
  	 */

    Area::create(['id' => 1, 'area_name' => 'Area 1', 'description' => 'Area 1', 'status' => 'a']);
    Area::create(['id' => 2, 'area_name' => 'Area 2', 'description' => 'Area 2', 'status' => 'a']);
    Area::create(['id' => 3, 'area_name' => 'Area 3', 'description' => 'Area 3', 'status' => 'a']);
    Area::create(['id' => 4, 'area_name' => 'Area 4', 'description' => 'Area 4', 'status' => 'a']);

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
