<?php

use Illuminate\Database\Seeder;
use App\Model\Order;
use App\Model\OrderNegotiation;
use App\Model\OrderApproval;

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
        'order' => [ 'id' => 1, 'user_id' => 7, 'status' => 'o', ],
        'buy' => [ 1 => [ 'volume' => 1000, 'price' => 51000 ] ],
        'sell' => [ 1 => [ 'volume' => 1000, 'price' => 53000 ] ],
        'user' => [ 1 => [ 'role' => 'approver' ], 8 => [ 'role' => 'associated' ], 7 => [ 'role' => 'admin' ] ],
        'approval' => [ 1 => [ 'status' => 'a' ], 2 => [ 'status' => 'a' ] ]
      ],
      [
        'order' => [ 'id' => 2, 'user_id' => 8, 'status' => 'o'],
        'buy' => [ 2 => [ 'volume' => 1100, 'price' => 59000 ] ],
        'sell' => [ 2 => [ 'volume' => 1100, 'price' => 61000 ] ],
        'user' => [ 1 => [ 'role' => 'approver' ], 7 => [ 'role' => 'associated' ], 8 => [ 'role' => 'admin' ] ],
        'approval' => [ 2 => [ 'status' => 'a' ] ]
      ],
      [
        'order' => [ 'id' => 3, 'user_id' => 7, 'status' => 'f'],
        'buy' => [ 3 => [ 'volume' => 1000, 'price' => 38000 ] ],
        'sell' => [ 3 => [ 'volume' => 1000, 'price' => 45000 ] ],
        'user' => [ 1 => [ 'role' => 'approver' ], 8 => [ 'role' => 'associated' ], 7 => [ 'role' => 'admin' ] ],
        'approval' => [ 2 => [ 'status' => 'a' ] ]
      ],
    ];

    foreach($array as $object){
      $order = Order::create($object['order']);
      $order->buys()->attach($object['buy']);
      $order->sells()->attach($object['sell']);
      $order->users()->attach($object['user']);
      $order->approval()->attach($object['approval']);
    }

    OrderNegotiation::create([
      'order_detail_id' => 1,
      'user_id' => 1,
      'old_volume' => 900,
      'old_price' => 51000,
      'new_volume' => 1000,
      'new_price' => 51000,
      'notes' => 'Negotiated, we\'ll get more',
    ]);
  }
}
