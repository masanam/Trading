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
      if(config('app.deployment') == 'berau') {
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
          // d = direct, o = or, a = and, 1/2/3/...  = angka
          //['order_approval_scheme_id' => 1,'sequence' => 1,'role_id' => 26, 'approval_scheme' => 'd'], // trade supervisor, direct
          ['order_approval_scheme_id' => 1,'sequence' => 1,'role_id' => 22, 'approval_scheme' => 'o'], // manager area 1, all
          ['order_approval_scheme_id' => 1,'sequence' => 2,'role_id' => 27, 'approval_scheme' => 'o'], // gm, 1 of all
          ['order_approval_scheme_id' => 1,'sequence' => 3,'role_id' => 21, 'approval_scheme' => 'a'], // cmo, 1 of all
          ['order_approval_scheme_id' => 1,'sequence' => 4,'role_id' => 11, 'approval_scheme' => 'o'], // ceo, or

          //untuk area 2
          ['order_approval_scheme_id' => 2,'sequence' => 1,'role_id' => 23, 'approval_scheme' => 'o'], // manager area 2, all
          ['order_approval_scheme_id' => 2,'sequence' => 2,'role_id' => 27, 'approval_scheme' => 'o'], // gm, 1 of all
          ['order_approval_scheme_id' => 2,'sequence' => 3,'role_id' => 21, 'approval_scheme' => 'a'], // cmo, 1 of all
          ['order_approval_scheme_id' => 2,'sequence' => 4,'role_id' => 11, 'approval_scheme' => 'o'], // ceo, or
          /*['order_approval_scheme_id' => 2,'sequence' => 1,'role_id' => 23, 'approval_scheme' => 'a'], // manager area 2, all
          ['order_approval_scheme_id' => 2,'sequence' => 2,'role_id' => 21, 'approval_scheme' => 'a'], // cmo, all
          ['order_approval_scheme_id' => 2,'sequence' => 3,'role_id' => 11, 'approval_scheme' => 'a'], // ceo, all*/
        ];
      }else if(config('app.deployment') == 'bib') {
        OrderApprovalScheme::create([
          'id' => 3,
          'order_approval_scheme_name' => 'Bib Approval Sequence'
        ]);

        $seq = [
          ['order_approval_scheme_id' => 3,'sequence' => 1,'role_id' => 28, 'approval_scheme' => 'o'],
          ['order_approval_scheme_id' => 3,'sequence' => 2,'role_id' => 29, 'approval_scheme' => 'o'],
          ['order_approval_scheme_id' => 3,'sequence' => 3,'role_id' => 11, 'approval_scheme' => 'o'],
        ];
      }

      foreach($seq as $s) OrderApprovalSchemeSequence::create($s);
    }
}
