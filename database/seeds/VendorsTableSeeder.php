<?php

use App\Model\Vendor;

use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::create([
            'company_name' => 'PT Mitra Bahari Sentosa',
            'phone' => '+62712314',
            'email' => 'info@mbs.com',
            'web' => 'https://www.mbs.com',
            'industry' => 'Freight',
            
            'city' => 'Jakarta',
            'address' => 'JL. Telaga Biru No.5, Banjarmasin',
            'description' => 'PT Mitra Bahari Sentosa operates as a freight tansporting company. The company is based in Banjarmasin, Indonesia. This is a subsidiary of Sunarko Group.',
            'status' => 'a'
        ]);
    }
}


