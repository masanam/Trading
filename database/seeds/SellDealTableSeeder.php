<?php

use Illuminate\Database\Seeder;

use App\Model\SellDeal;

class SellDealTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SellDeal::create([
	        'id' => 1,
	        'sell_order_id' => 2,
	        'user_id' => 2,
	        'approver_id' => 1,
	        'deal_id' => 1,

	        'type' => 'sell',

	        'status' => 'a'
        ]);

        SellDeal::create([
	        'id' => 2,
	        'sell_order_id' => 1,
	        'user_id' => 3,
	        'approver_id' => 2,
	        'deal_id' => 2,

	        'type' => 'sell',

	        'status' => 'a'
        ]);

        SellDeal::create([
	        'id' => 3,
	        'sell_order_id' => 3,
	        'user_id' => 1,
	        'approver_id' => 1,
	        'deal_id' => 3,

	        'type' => 'sell',

	        'status' => 'a'
        ]);
    }
}
