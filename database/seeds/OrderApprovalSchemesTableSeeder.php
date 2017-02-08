<?php

use Illuminate\Database\Seeder;

use App\Model\OrderApprovalScheme;
use App\Model\OrderApprovalSchemeSequence;

class OrderApprovalSchemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderApprovalScheme::create([
        	'id' => 1,
					'order_approval_scheme_name' => 'Area 1 Trade Approval Sequence',
					'sell_area_id' => 1
        ]);

        OrderApprovalScheme::create([
        	'id' => 2,
					'order_approval_scheme_name' => 'Area 2 Trade Approval Sequence',
					'sell_area_id' => 2
        ]);

        $seq = [
        	//untuk order area 1
        	['order_approval_scheme_id' => 1,'sequence' => 1,'role_id' => 26, 'approval_scheme' => 'd'], // trade supervisor, direct
        	['order_approval_scheme_id' => 1,'sequence' => 2,'role_id' => 22, 'approval_scheme' => 'a'], // manager area 1, all
        	['order_approval_scheme_id' => 1,'sequence' => 3,'role_id' => 21, 'approval_scheme' => '1'], // cmo, 1 of all
        	['order_approval_scheme_id' => 1,'sequence' => 4,'role_id' => 11, 'approval_scheme' => 'o'], // ceo, or

        	//untuk area 2
        	['order_approval_scheme_id' => 2,'sequence' => 1,'role_id' => 23, 'approval_scheme' => 'a'], // manager area 2, all
        	['order_approval_scheme_id' => 2,'sequence' => 2,'role_id' => 21, 'approval_scheme' => 'a'], // cmo, all
        	['order_approval_scheme_id' => 2,'sequence' => 3,'role_id' => 11, 'approval_scheme' => 'a'], // ceo, all
				];

				foreach($seq as $s) OrderApprovalSchemeSequence::create($s);	
    }
}
