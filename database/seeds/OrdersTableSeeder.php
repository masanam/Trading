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
        'order' => [ 'id' => 1, 'user_id' => 7, 'status' => 'p', ],
        'buy' => [ 1 => [ 'volume' => 500, 'price' => 25000, 'trading_term' => 'FOB MV', 'payment_term' => 'TT' ], 4 => [ 'volume' => 500, 'price' => 26000, 'trading_term' => 'FOB MV', 'payment_term' => 'TT' ] ],
        'sell' => [ 1 => [ 'volume' => 1000, 'price' => 53000, 'trading_term' => 'FOB MV', 'payment_term' => 'TT' ] ],
        'user' => [ 1 => [ 'role' => 'approver' ], 8 => [ 'role' => 'associated' ], 7 => [ 'role' => 'admin' ] ],
        'approval' => [ 1 => [ 'status' => 'a' ], 2 => [ 'status' => 'a' ] ]
      ],
      [
        'order' => [ 'id' => 2, 'user_id' => 8, 'status' => 'p'],
        'buy' => [ 2 => [ 'volume' => 1100, 'price' => 59000, 'trading_term' => 'FOB MV', 'payment_term' => 'TT' ] ],
        'sell' => [ 2 => [ 'volume' => 1100, 'price' => 61000, 'trading_term' => 'FOB MV', 'payment_term' => 'TT' ] ],
        'user' => [ 1 => [ 'role' => 'approver' ], 7 => [ 'role' => 'associated' ], 8 => [ 'role' => 'admin' ] ],
        'approval' => [ 2 => [ 'status' => 'a' ] ]
      ],
      [
        'order' => [ 'id' => 3, 'user_id' => 7, 'status' => 'f'],
        'buy' => [ 3 => [ 'volume' => 1000, 'price' => 38000, 'trading_term' => 'FOB MV', 'payment_term' => 'TT' ] ],
        'sell' => [ 3 => [ 'volume' => 1000, 'price' => 45000, 'trading_term' => 'FOB MV', 'payment_term' => 'TT' ] ],
        'user' => [ 1 => [ 'role' => 'approver' ], 8 => [ 'role' => 'associated' ], 7 => [ 'role' => 'admin' ] ],
        'approval' => [ 2 => [ 'status' => 'a' ] ]
      ],
    ];

    foreach($array as $object){
      $order = Order::create($object['order']);
      $order->buys()->attach($object['buy']);
      $order->sells()->attach($object['sell']);
      $order->users()->attach($object['user']);
      $order->approvals()->attach($object['approval']);
    }

    OrderNegotiation::create([
      'order_detail_id' => 1,
      'user_id' => 1,
      'volume' => 900,
      'price' => 50,
      'trading_term' => 'FOB MV',
      'payment_term' => 'TT',
      'notes' => 'Negotiated, we\'ll get more',
    ]);
    OrderNegotiation::create([
      'order_detail_id' => 3,
      'user_id' => 1,
      'volume' => 500,
      'price' => 50,
      'trading_term' => 'FOB MV',
      'payment_term' => 'NET30',
      'notes' => 'Initial Deal',
    ]);
    OrderNegotiation::create([
      'order_detail_id' => 3,
      'user_id' => 1,
      'volume' => 500,
      'price' => 49,
      'trading_term' => 'FOB MV',
      'payment_term' => 'TT',
      'notes' => 'Price decreased by 1, they agreed, but need to wire as fast as possible',
    ]);
  }
}
