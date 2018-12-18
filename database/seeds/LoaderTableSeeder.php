<?php

use Illuminate\Database\Seeder;
use App\Model\Loader;

class LoaderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {      
      Loader::create([
        'id' => 1,
        'loader_name' => 'FOTP Derawan',
        'status' => 'a'
      ]);

      Loader::create([
        'id' => 2,
        'loader_name' => 'FC. Blitz',
        'status' => 'a'
      ]);

      Loader::create([
        'id' => 3,
        'loader_name' => 'FTS. Bulk Celebes',
        'status' => 'a'
      ]);

      Loader::create([
        'id' => 4,
        'loader_name' => 'FTS. Bulk Borneo',
        'status' => 'a'
      ]);

      Loader::create([
        'id' => 5,
        'loader_name' => 'FTS. Bulk Java',
        'status' => 'a'
      ]);

      Loader::create([
        'id' => 6,
        'loader_name' => 'FTS. Bulk Sumatra',
        'status' => 'a'
      ]);

      Loader::create([
        'id' => 7,
        'loader_name' => 'Gear Vessel',
        'status' => 'a'
      ]);
      
    }
}
