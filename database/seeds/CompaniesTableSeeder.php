<?php

use App\Model\User;
use App\Model\Company;
use App\Model\Contact;
use App\Model\Area;

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Area::create([
      'id' => 1,
      'description' => 'Area 1',
      'status' => 'a'
    ]);

    Area::create([
      'id' => 2,
      'description' => 'Area 2',
      'status' => 'a'
    ]);

    Area::create([
      'id' => 3,
      'description' => 'Area 3',
      'status' => 'a'
    ]);

    Area::create([
      'id' => 4,
      'description' => 'Area 4',
      'status' => 'a'
    ]);

    Company::create([
      'id' => 1,
      'user_id' => '2' ,
      'area_id' =>  1,
      'company_name' => 'PT.Wilmar Nabati Indonesia' ,
      'is_affiliated'=>'1',
      'phone' => '(031) 3979414' ,
      'email' => 'info@wilmar-international.com' ,
      'web' => 'www.wilmar-international.com' ,
      'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur' ,
      'city' => 'Gresik' ,
      'country'=> 'ID',
      'industry' => 'Palm Oil Manufacturer' ,
      'annual_demand'=>'16800000',
      'preferred_trading_term'=>'FOB MV',
      'preferred_payment_term'=> 'LC',
      'description' => 'This is an palm oil company' ,
      'company_type' => 'c',
      'status' => 'a' 
    ]) ;

    Company::create([
      'id' => 2,
      'user_id' => '1' ,
      'area_id' =>  1,
      'company_name' => 'PT.SMART' ,
      'country'=> 'ID',
      'is_affiliated'=>'1',
      'phone' => '(031) 3979414' ,
      'email' => 'info@wilmar-international.com' ,
      'web' => 'www.wilmar-international.com' ,
      'industry' => 'Palm Oil Manufacturer' ,
      'annual_demand'=>'16800000',
      'preferred_trading_term'=>'FOB MV',
      'preferred_payment_term'=> 'LC',
      'city' => 'Gresik' ,
      'address' => 'Jl. Kapten Darmo Sugondo No.56, Sidorukun, Kec. Gresik, Kabupaten Gresik, Jawa Timur' ,
      'description' => 'This is an palm oil company' ,
      'company_type' => 'c',
      'status' => 'a' 
    ]) ;

    Company::create([
      'id' => 3,
      'user_id' => 1,
      'area_id' =>  1,
      'company_name' => 'PT Mitra Bahari Sentosa',
      'country'=> 'ID',
      'is_affiliated'=> 0,
      'phone' => '+62712314',
      'email' => 'info@mbs.com',
      'web' => 'https://www.mbs.com',
      'industry' => 'Freight',
      
      'city' => 'Jakarta',
      'address' => 'JL. Telaga Biru No.5, Banjarmasin',
      'description' => 'PT Mitra Bahari Sentosa operates as a freight tansporting company. The company is based in Banjarmasin, Indonesia. This is a subsidiary of Sunarko Group.',

      'company_type' => 'v',
      'status' => 'a'
    ]);

    Company::create([
      'id'=>4,
      'company_name' => 'Indexim',
      'user_id' => '1',
      'area_id' =>  2,
      'phone' => '',
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
      'address' =>'',
      'description' => '',
      'company_type' => 's',
      'purchasing_countries' => 'ID',
      'status' => 'a'
    ]);

    Company::create([
      'id'=>5,
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

    Company::create([                
      'id'=>6,
      'company_name' => 'PT Borneo Indobara',
      'user_id' => '3',
      'area_id' =>  2,
      'is_affiliated'=>'1',
      'annual_sales'=>'02',
      'preferred_trading_term'=>'FOB BARGE',
      'preferred_payment_term'=> 'LC',
      'purchasing_countries'=>'',
      'phone' => '+622131990092',
      'email' => 'info@borneo.com',
      'web' => 'https://www.borneo-indobara.com',
      'country'=> 'ID',
      'industry' => 'Coal Mining',
      'city' => 'Banjarmasin',
      'address' => 'Plaza BII 2 Lt. 7 Jl. M. H. Thamrin No. 51',
      'description' => 'In the initial stage, all the coal shipment is conducted at the Muara Satui anchorage point (Lat. 03’56 S / 115’30 E). Transshipment to the main vessel is done using barges from two ports on the banks of Satui River. Loading rate at the anchorage point is over 8,000 MT. Borneo Indobara is currently building a main port facility in the coast of Sebamban, which will enable the company to increase its throughput significantly. This port will be commisioned by the end of 2008.',
      'company_type' => 't',
      'status' => 'a'
    ]);
    
    Company::create([
      'id'=>7,
      'company_name' => 'Tiger Energy',
      'user_id' => '1',
      'area_id' =>  2,
      'phone' => '',
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
      'address' =>'',
      'description' => '',
      'company_type' => 's',
      'purchasing_countries' => 'ID',
      'status' => 'a'
    ]);

    Company::create([
      'id'=>8,
      'company_name' => 'Amanah',
      'user_id' => '1',
      'area_id' =>  2,
      'phone' => '',
      'is_affiliated'=>'1',
      'annual_sales'=>'0',
      'preferred_trading_term'=>'FOB MV',
      'preferred_payment_term'=> 'LC',
      'purchasing_countries'=>'',
      'email' => '',
      'web' => '',
      'country'=> 'ID',
      'industry' => 'Coal Mining',
      'city' => 'Kalimantan Selatan',
      'address' =>'',
      'description' => '',
      'company_type' => 's',
      'purchasing_countries' => 'ID',
      'status' => 'a'
    ]);

    Company::create([
      'id'=>9,
      'company_name' => 'Bukit Baiduri Energi',
      'user_id' => '2',
      'area_id' =>  2,
      'phone' => '',
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
      'address' =>'',
      'description' => '',
      'company_type' => 's',
      'purchasing_countries' => 'ID',
      'status' => 'a'
    ]);

    Company::create([
      'id'=>10,
      'company_name' => 'Arutmin',
      'user_id' => '3',
      'area_id' =>  2,
      'phone' => '',
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
      'address' =>'',
      'description' => '',
      'company_type' => 's',
      'purchasing_countries' => 'ID',
      'status' => 'a'
    ]);

    Contact::create([
      'id' => 1,
      'name' => 'Fuganto Widjaja',
      'company_id' => 1,
      'user_id' => 1,
      'email' => 'fu@gems.com',
      'phone' => '+62811111111',
      'status' => 'a'
    ]);

    

    //1-5
    
    // Seller::create(['company_name' => 'Amanah','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Selatan','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'Bara Jaya Utama','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Timur','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'Bukit Baiduri Energi','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Timur','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    
    // //6-10

    // Seller::create(['company_name' => 'Kaltim Jaya Bara','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Timur','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);  
    // Seller::create(['company_name' => 'Arutmin','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Selatan','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'PT. Kideco Jaya Agung','user_id' => '1','phone' => '021 5257626','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Timur','address' =>'Menara Mulia 17th Floor, Jl. Jend Gatot Subroto Kav 9, Central Jakarta 12930','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'Adaro','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Selatan','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    
    // //11-15
    // Seller::create(['company_name' => 'Jhonlin Group','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Selatan','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'Asmin Koalindo Tuhup','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Tengah','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'Sunfan','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Selatan','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'Nugraha Jorong Pratama','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Selatan','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'PT. Bengkulu Bio Energi','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB Barge','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Bengkulu','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    
    // //16-20
    // Seller::create(['company_name' => 'PT. Bukit Asam. TBk','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Sumatera Selatan','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'CV. Surya Sunfan Dwi Bahtera','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Selatan','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'Integra','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB Barge','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Jambi','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'Pada Idi','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Tengah','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'PT. Inkor Prima Coal','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Timur','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    
    // //21-24
    // Seller::create(['company_name' => 'PT. Rain TBK','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Timur','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'Sentosa Laju Energi','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'FOB MV','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Timur','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'Sunfan','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Kalimantan Selatan','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);
    // Seller::create(['company_name' => 'PT. Bara Harmonis Batang Asam','user_id' => '1','phone' => '','is_affiliated'=>'1','annual_sales'=>'0','preferred_trading_term'=>'','preferred_payment_term'=>'LC at Sight','purchasing_countries'=>'','email' => '','web' => '','country'=> 'ID','industry' => 'Coal Mining','city' => 'Jambi','address' =>'','latitude' =>0,'longitude' => 0,'description' => '','status' => 'a']);

    // Seller::create([                
    //     'company_name' => 'PT Kuansing Inti Makmur',            
    //     'user_id' => '2',
    //     'phone' => '+6276132317',
    //     'is_affiliated'=>'1',
    //     'annual_sales'=>'02',
    //     'preferred_trading_term'=>'FOB MV',
    //     'preferred_payment_term'=>'',
    //     'purchasing_countries'=>'',
    //     'email' => 'info@kuansing.com',
    //     'web' => 'https://www.kim.com',
    //     'country'=> 'ID',
    //     'industry' => 'Coal Mining',
    //     'city' => 'Pekanbaru',
    //     'country'=> 'ID',
    //     'address' => 'JL. Jend Sudirman No.9, Tengkerang Sel., Bukit Raya',
    //     'latitude' => '0.496853',
    //     'longitude' => '101.4564464',
    //     'description' => 'PT Kuansing Inti Makmur operates as a coal exploration and mining company. The company is based in Jakarta, Indonesia. PT Kuansing Inti Makmur operates as a subsidiary of PT Dian Swastatika Sentosa Tbk.',
    //     'status' => 'a'
    // ])/*->user()->attach(6)*/;

    // Seller::create([                
    //     'company_name' => 'PT Borneo Indobara',
    //     'user_id' => '3',
    //     'is_affiliated'=>'1',
    //     'annual_sales'=>'02',
    //     'preferred_trading_term'=>'cif',
    //     'preferred_payment_term'=>'',
    //     'purchasing_countries'=>'',
    //     'phone' => '+622131990092',
    //     'email' => 'info@borneo.com',
    //     'web' => 'https://www.borneo-indobara.com',
    //     'country'=> 'ID',
    //     'industry' => 'Coal Mining',
    //     'city' => 'Banjarmasin',
    //     'country'=> 'ID',
    //     'address' => 'Plaza BII 2 Lt. 7 Jl. M. H. Thamrin No. 51',
    //     'latitude' => '-6.21539',
    //     'longitude' => '106.81157',
    //     'description' => 'In the initial stage, all the coal shipment is conducted at the Muara Satui anchorage point (Lat. 03’56 S / 115’30 E). Transshipment to the main vessel is done using barges from two ports on the banks of Satui River. Loading rate at the anchorage point is over 8,000 MT. Borneo Indobara is currently building a main port facility in the coast of Sebamban, which will enable the company to increase its throughput significantly. This port will be commisioned by the end of 2008.',
    //     'status' => 'a'
    // ])/*->user()->attach(6)*/;

    // Seller::create([                
    //     'company_name' => 'PT Golden Energy Mines',        
    //     'user_id' => '3',
    //     'is_affiliated'=>'1',
    //     'annual_sales'=>'02',
    //     'preferred_trading_term'=>'pas',
    //     'preferred_payment_term'=>'',
    //     'purchasing_countries'=>'',
    //     'phone' => '+622150186888',
    //     'email' => 'info@.com',
    //     'web' => 'https://www..com',
    //     'country'=> 'ID',
    //     'industry' => 'Coal Mining',
    //     'city' => 'Jakarta',
    //     'country'=> 'ID',
    //     'address' => 'Lantai 7, Sinarmas Land Plaza Tower 2, Jl. M.H. Thamrin No.51, RT.9/RW.4, Gondangdia, Menteng',
    //     'latitude' => '-6.1901426',
    //     'longitude' => '106.8231203',
    //     'description' => 'Golden Energy Mines is the coal mining group of Sinarmas. We operate in three areas: South Kalimantan, Central Kalimantan, and South Sumatera, Jambi. The Company has resources as much as 1.93 billion tons of thermal coal and coal reserves of about 849 million tons; which provides promising prospects for growth in operations and financial performance in the future for a long period.',
    //     'status' => 'a'
    // ])/*->user()->attach(6);*/;
  }
}
