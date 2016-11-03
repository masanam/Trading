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
    		$array = [
    			[
    				'order' => [ 'id' => 1, 'user_id' => 2, 'status' => 'o', ],
    				'buy' => [ 1 => [ 'volume' => 1000, 'price' => 51000 ] ],
    				'sell' => [ 1 => [ 'volume' => 1000, 'price' => 53000 ] ]
    			],
    			[
    				'order' => [ 'id' => 2, 'user_id' => 3, 'status' => 'o'],
    				'buy' => [ 2 => [ 'volume' => 1100, 'price' => 59000 ] ],
    				'sell' => [ 2 => [ 'volume' => 1100, 'price' => 61000 ] ]
    			],
    			[
    				'order' => [ 'id' => 3, 'user_id' => 2, 'status' => 'f'],
    				'buy' => [ 3 => [ 'volume' => 1000, 'price' => 38000 ] ],
    				'sell' => [ 3 => [ 'volume' => 1000, 'price' => 45000 ] ]
    			],
    		];

    		foreach($array as $object){
	        $order = Order::create($object['order']);
	        $order->buys()->attach($object['buy']);
	        $order->sells()->attach($object['sell']);
    		}
    }
}
