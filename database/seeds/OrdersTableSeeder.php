<?php

use Illuminate\Database\Seeder;
use App\Model\Order;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'id' => 1,
            'user_id' => 2,
            'status' => 'o'
        ])->attach([ 1 => [ 'volume' => 1000, 'price' => 53000 ] ]);

        Order::create([
            'id' => 2,
            'user_id' => 3,
            'status' => 'f'
        ])->attach([ 2 => [ 'volume' => 1100, 'price' => 61000 ] ]);

        Order::create([
            'id' => 3,
            'user_id' => 2,
            'status' => 'x'
        ])->attach([ 3 => [ 'volume' => 1000, 'price' => 38000 ] ]);

        Order::create([
            'id' => 4,
            'user_id' => 1,
            'status' => 'c'
        ])->attach([ 4 => [ 'volume' => 1000, 'price' => 45000 ] ]);

        Order::create([
            'id' => 5,
            'user_id' => 1,
            'status' => 'd'
        ])->attach([ 5 => [ 'volume' => 1000, 'price' => 51000 ] ]);
    }
}
