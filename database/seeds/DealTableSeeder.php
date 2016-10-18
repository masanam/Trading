<?php

use Illuminate\Database\Seeder;

use App\Model\Deal;

class DealTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Deal::create([
            'id' => 1,
            'user_id' => 2,
            'status' => 'a'
        ]);

        Deal::create([
            'id' => 2,
            'user_id' => 3,
            'status' => 'a'
        ]);

        Deal::create([
            'id' => 3,
            'user_id' => 2,
            'status' => 'a'
        ]);
    }
}
