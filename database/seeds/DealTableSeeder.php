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
            'status' => 'o'
        ]);

        Deal::create([
            'id' => 2,
            'user_id' => 3,
            'status' => 'f'
        ]);

        Deal::create([
            'id' => 3,
            'user_id' => 2,
            'status' => 'x'
        ]);

        Deal::create([
            'id' => 4,
            'user_id' => 1,
            'status' => 'c'
        ]);

        Deal::create([
            'id' => 5,
            'user_id' => 1,
            'status' => 'd'
        ]);
    }
}
