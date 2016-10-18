<?php

use Illuminate\Database\Seeder;
use App\Model\BuyDeal;

class BuyDealTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	BuyDeal::create([
	        'id' => 1,
	        'buy_order_id' => 2,
	        'user_id' => 2,
	        'approver_id' => 1,
	        'deal_id' => 1,

	        'type' => 'buy',

	        'status' => 'a'
        ]);

        BuyDeal::create([
	        'id' => 2,
	        'buy_order_id' => 1,
	        'user_id' => 3,
	        'approver_id' => 2,
	        'deal_id' => 2,

	        'type' => 'buy',

	        'status' => 'a'
        ]);

        BuyDeal::create([
	        'id' => 3,
	        'buy_order_id' => 3,
	        'user_id' => 1,
	        'approver_id' => 1,
	        'deal_id' => 3,

	        'type' => 'buy',

	        'status' => 'a'
        ]);
    }
}
