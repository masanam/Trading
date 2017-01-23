<?php

namespace App\Http\Controllers;

use App\Model\Contract;
use App\Model\Order;
use App\Model\Shipment;

use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function __construct() {
      $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function index(Request $req)
     {
       $range = [];
       $contracts = Contract::with('shipments', 'orders', 'orders.sells', 'orders.sells.company', 'orders.sells.product')->where('status', 'a');

       $limit = $req->pageSize ? $req->pageSize : 3;
       $skip = ( $req->pageSize * $req->page ) ? ( $req->pageSize * $req->page ) : 0;

       if($req->area_id){
         $contracts = $contracts->whereHas('orders.sells.company', function($q) use ($req) {
           $q->whereRaw('area_id = '.$req->area_id);

         });
       }

       if($req->company_id){
         $contracts = $contracts->whereHas('orders.sells.company',function($q) use ($req) {
           $q->whereRaw('company_id  = '.$req->company_id);
         });
       }

       if($req->q)
       {
         $param = $req->q;
         $contracts = $contracts->where(function($query) use ($param)
         {
          // $query->orWhereHas('orders.sells.company',function($q) use ($param)
          $query->orWhereHas('orders.sells.company',function($q) use ($param)
          {
           $q->where('company_name','LIKE','%'.$param.'%');
          })
          ->orWhere('contract_no', 'LIKE', '%'.$param.'%')
          ->orWhere('date_from','LIKE','%'.$param.'%')
          ->orWhere('date_to','LIKE','%'.$param.'%');
         });

       }
       //
      //  if($req->q)
      //  {
      //    $param = $req->q;
      //    $shipments = $shipments->where(function($query) use ($param)
      //    {
      //      return $query->whereHas('contracts', function($q) use ($param)
      //      {
      //        $q->whereRaw('`contract_no` LIKE "%'.$param.'%"');
      //      })
      //      ->orWhereHas('suppliers', function($q) use ($param)
      //      {
      //        $q->whereRaw('`company_name` LIKE "%'.$param.'%"');
      //      })
      //      ->orWhereRaw('laycan_start LIKE "%'.$param.'%"')
      //      ->orWhereRaw('laycan_start LIKE "%'.$param.'%"')
      //      ->orWhereRaw('shipment_no LIKE "%'.$param.'%"');
      //    });
      //  }


      //  if($req->scheduled) {
      //    if($req->range) {
      //      $range = explode(',', $req->range);
      //      $from = explode('-', $range[0]);
      //      $till = explode('-', $range[1]);
      //      $monthFrom = $from[0]; $yearFrom = $from[1];
      //      $monthTill = $till[0]; $yearTill = $till[1];
      //      $fromDate = new Carbon('first day of ' . $monthFrom . ' ' . $yearFrom);
      //      $tillDate = new Carbon('last day of ' . $monthTill . ' ' . $yearTill);
      //      $shipments = $shipments->whereBetween(DB::raw('date(laycan_start)'), [$fromDate, $tillDate])
      //        ->orWhereBetween(DB::raw('date(laycan_end)'), [$fromDate, $tillDate]);
      //    }
      //    else
      //      $shipments = $shipments
      //        ->where( DB::raw('MONTH(laycan_start)'), '=', date('n') )
      //        ->orWhere( DB::raw('MONTH(laycan_end)'), '=', date('n') );
       //
       //
      //  }

       $contracts = $contracts->get();

       return response()->json($contracts, 200);
     }

    // public function index(Request $req)
    // {
    //   $contracts = Contract::with('shipments', 'orders', 'orders.sells', 'orders.sells.company', 'orders.sells.product')->where('status', 'a');
    //   if($req->unscheduled) {
    //     $contracts = $contracts->has('shipments', '<' , 1);
    //   }
    //
    //   $contracts = $contracts->get();
    //
    //   return response()->json($contracts, 200);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::where('status', 'f')->find($request->order_id);
        if($order){
          $contract = new Contract();

          $contract->contract_no = $request->contract_no;
          $contract->order_id = $request->order_id;
          $contract->shipment_count = $request->shipment_count;
          $contract->term = $request->term;
          $contract->term_desc = $request->term_desc;
          $contract->date_from = $request->date_from;
          $contract->date_to = $request->date_to;
          $contract->status = 'a';

          $contract->save();

          return response()->json($contract, 200);
        }
        else return response()->json(['message'=>'not found'], 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$user = User::with('directSubordinates','directManager','roles')->find($user);
        $contract = Contract::with('shipments', 'orders', 'orders.buys', 'orders.buys.company', 'orders.buys.product', 'orders.sells', 'orders.sells.company', 'orders.sells.product')->find($id);
        return $contract;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $contract = Contract::find($id);

      if(!$contract) {
        return response()->json(['message' => 'not found'], 404);
      }
      else {
        $contract->contract_no = $request->contract_no ? $request->contract_no : $contract->contract_no;
        $contract->order_id = $request->order_id ? $request->order_id : $contract->order_id;
        $contract->shipment_count = $request->shipment_count ? $request->shipment_count : $contract->shipment_count;
        $contract->term = $request->term ? $request->term : $contract->term;
        $contract->term_desc = $request->term_desc ? $request->term_desc : $contract->term_desc;
        $contract->date_from = $request->date_from ? $request->date_from : $contract->date_from;
        $contract->date_to = $request->date_to ? $request->date_to : $contract->date_to;
        $contract->status = $request->status ? $request->status : 'a';

        $contract->save();

        return response()->json($contract, 200);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract = Contract::find($id);

        if(!$contract) {
          return response()->json(['message' => 'not found'], 404);
        }
        else {
          $contract->status = 'x';

          $contract->save();

          return response()->json($contract, 200);
        }
    }
}
