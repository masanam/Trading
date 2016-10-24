<?php

namespace App\Http\Controllers;

use App\Model\SellDeal;
use App\Model\SellOrder;
use App\Model\SellOrderPricing;
use App\Model\SellDealApproval;

use Illuminate\Http\Request;
use Illuminate\Http\Auth;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class SellDealController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sell_deal = SellDeal::where('status', 'a')->with(
                            'SellOrder', 'SellOrder.SellOrderPricing', 'SellOrder.Seller',
                             'SellOrder.Seller.User', 'User', 'Deal'
                        )->get();

        return response()->json($sell_deal, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        $sell_deal = new SellDeal();
        $sell_deal->sell_order_id = $request->sell_order_id;
        $sell_deal->user_id = $request->user_id;
        $sell_deal->deal_id = $request->deal_id  ? $request->deal_id : NULL;
        $sell_deal->type = "sell";
        $sell_deal->status = "a";
        $sell_deal->save();
        
        $config_approver = config('approver');
        
        /*
        *   every approver in the config file, 
        *   will get the notification, 
        *   and can approve any deal
        */
        foreach($config_approver as $approver){
          $sell_deal_approval = new SellDealApproval();
          $sell_deal_approval->sell_deal_id = $sell_deal->id;
          $sell_deal_approval->user_id = $sell_deal->user_id;
          $sell_deal_approval->approver_id = '';
          $sell_deal_approval->status = "p";
          $sell_deal_approval->save();
        }

        event(new \App\Events\SellDealNotification($sell_deal));
        event(new \App\Events\SellDealApprovalNotification($sell_deal_approval));

        return response()->json($sell_deal, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sell_deal = SellDeal::with(
                            'SellOrder', 'SellOrder.SellOrderPricing', 'SellOrder.Seller',
                             'SellOrder.Seller.User', 'User', 'Deal'
                             )->find($id);

        if($sell_deal) {
            if($sell_deal->status == 'a') {
                return response()->json([
                    'success' => TRUE,
                    $sell_deal
                    ], 200);
            } else {
                return response()->json(['error' => 'deactivated record'], 404);
            }
        } else {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sell_deal)
    {
        $sell_deal = SellDeal::find($sell_deal);

        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$sell_deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $sell_deal->sell_order_id = $request->sell_order_id;
        $sell_deal->user_id = $request->user_id;
        $sell_deal->deal_id = $request->deal_id  ? $request->deal_id : NULL;
        $sell_deal->status = "a";
        $sell_deal->save();

        return response()->json($sell_deal, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sell_deal)
    {
        $sell_deal = SellDeal::find($sell_deal);

        if (!$sell_deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $sell_deal->status = 'x';
        $sell_deal->save();

        return response()->json($sell_deal, 200);
    }
    
    /**
     * Remove the specified resource from storage by dealId
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyByDeal($dealId)
    {
        if (!$dealId) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

       $sell_deal = DB::table('sell_deal')->where('deal_id', $dealId)->update(['status' => 'x']);

       return response()->json($sell_deal, 200);
    }
    
    // Get Sell Deal by Deal ID
    public function getByDeal($dealId) {
      if (!$dealId) {
          return response()->json([
              'message' => 'Not found'
          ] ,404);
      }
      
      $sell_deal = SellDeal::with('SellOrder', 'SellOrder.SellOrderPricing', 'SellOrder.Seller',
                             'SellOrder.Seller.User', 'User', 'Deal')->where([['deal_id', $dealId], ['status', 'a']])
             ->orderBy('id', 'asc')
             ->get();


      return response()->json($sell_deal, 200);
    }

    // Get One Sell Deal by Deal ID and Sell Order ID
    public function getOneByDealAndOrder($sell_order, $dealId) {
        $sell_deal = SellDeal::with('SellOrder', 'SellOrder', 'SellOrder.SellOrderPricing', 'SellOrder.Seller',
                             'SellOrder.Seller.User', 'User', 'Deal')
                    ->where([['deal_id', $dealId], 
                      ['status', 'a'],
                      ['sell_order_id', $sell_order]])
               ->orderBy('id', 'asc')
               ->first();

        return response()->json($sell_deal, 200);
    }

    public function approval(Request $request, $sell_deal, $approval) {
        if (!$sell_deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $sell_deal = SellDeal::find('id');

        $sell_deal_approval = new SellDealApproval();
        $sell_deal_approval->sell_deal_id = $sell_deal->id;
        $sell_deal_approval->user_id = $sell_deal->user_id;
        $sell_deal_approval->approver_id = $request->approver_id;
        $sell_deal_approval->status = $approval;

        $sell_deal_approval->save();

        event(new \App\Events\SellDealApprovalNotification($sell_deal_approval));

        return response()->json($sell_deal_approval, 200);
    }
}
