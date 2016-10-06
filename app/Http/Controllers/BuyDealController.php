<?php

namespace App\Http\Controllers;

use App\Model\BuyDeal;
use App\Model\BuyOrder;
use App\Model\BuyOrderPricing;
use App\Model\BuyDealApproval;
use App\Model\BuyDealChat;

use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class BuyDealController extends Controller
{
    public function __construct() {
        // $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buy_deal = BuyDeal::where('status', 'a')
                        ->with(
                            'BuyOrder', 'BuyOrder.BuyOrderPricing', 'BuyOrder.Buyer',
                             'BuyOrder.Buyer.User', 'User', 'Deal', 'BuyDealChat'
                        )->get();

        return response()->json($buy_deal, 200);
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
                'error' => 'Bad Request'
            ], 400);
        }

        $buy_order = BuyOrder::find($request->buy_order_id);

        $buy_deal = new BuyDeal();
        $buy_deal->buy_order_id = $request->buy_order_id;
        $buy_deal->user_id = $request->user_id;
        $buy_deal->deal_id = $request->deal_id  ? $request->deal_id : NULL;
        $buy_deal->type = "buy";
        $buy_deal->status = "a";
        $buy_deal->save();
        
        $config_approver = config('approver');
        
        foreach($config_approver as $approver){
          $buy_deal_approval = new BuyDealApproval();
          $buy_deal_approval->buy_deal_id = $buy_deal->id;
          $buy_deal_approval->user_id = $buy_deal->user_id;
          $buy_deal_approval->approver = $approver;
          $buy_deal_approval->status = "p";
          $buy_deal_approval->save();
        }
        
        event(new \App\Events\BuyDealNotification($buy_deal));
        event(new \App\Events\BuyDealApprovalNotification($buy_deal_approval));

        return response()->json($buy_deal, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buy_deal = BuyDeal::with(
                            'BuyOrder', 'BuyOrder.BuyOrderPricing', 'BuyOrder.Buyer',
                             'BuyOrder.Buyer.User', 'User', 'Deal', 'BuyDealChat'
                             )->find($id);

        if($buy_deal) {
            if($buy_deal->status == 'a') {
                return response()->json([
                    'success' => TRUE,
                    $buy_deal
                    ], 200);
            } else {
                return response()->json(['error' => 'deactivated record'], 404);
            }
        } else {
            return response()->json(['error' => 'Not found'], 404);
        }
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
                'error' => 'Not found'
            ] ,404);
        }

        $buy_deal = DB::table('buy_deal')->where('deal_id', $dealId)->update(['status' => 'x']);

        return response()->json($buy_deal, 200);
    }
    
    // Get All Buy Deal by Deal ID
    public function getByDeal($dealId) {
        $buy_deal = BuyDeal::with('BuyOrder', 'BuyOrder.BuyOrderPricing', 'BuyOrder.Buyer',
                             'BuyOrder.Buyer.User', 'User', 'Deal', 'BuyDealChat')->where([['deal_id', $dealId], ['status', 'a']])
               ->orderBy('id', 'asc')
               ->get();


        return response()->json($buy_deal, 200);
    }

    // Get One Buy Deal by Deal ID
    public function getOneByDeal($buy_deal, $dealId) {
        $buy_deal = BuyDeal::with('BuyOrder', 'BuyOrder.BuyOrderPricing', 'BuyOrder.Buyer',
                             'BuyOrder.Buyer.User', 'User', 'Deal', 'BuyDealChat')
                    ->where([['deal_id', $dealId], 
                      ['status', 'a']])
               ->orderBy('id', 'asc')
               ->find($buy_deal);

        return response()->json($buy_deal, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuyDeal $buy_deal)
    {
        if (!$request) {
            return response()->json([
                'error' => 'Bad Request'
            ], 400);
        }

        if (!$buy_deal) {
            return response()->json([
                'error' => 'Not found'
            ] ,404);
        }

        $buy_deal->buy_order_id = $request->buy_order_id;
        $buy_deal->user_id = $request->user_id;
        $buy_deal->deal_id = $request->deal_id  ? $request->deal_id : NULL;
        $buy_deal->status = "a";
        $buy_deal->save();

        return response()->json($buy_deal, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuyDeal $buy_deal)
    {
        if (!$buy_deal) {
            return response()->json([
                'error' => 'Not found'
            ] ,404);
        }

        $buy_deal->status = 'x';
        $buy_deal->save();

        return response()->json($buy_deal, 200);
    }

    public function approval(Request $request, $buy_deal, $approval) {
        if (!$buy_deal) {
            return response()->json([
                'error' => 'Not found'
            ] ,404);
        }

        $buy_deal = BuyDeal::find('id');

        $buy_deal_approval = new BuyDealApproval();
        $buy_deal_approval->buy_deal_id = $buy_deal->id;
        $buy_deal_approval->user_id = $buy_deal->user_id;
        $buy_deal_approval->approver = $request->approver_id;
        $buy_deal_approval->status = $approval;

        $buy_deal_approval->save();

        event(new \App\Events\BuyDealApprovalNotification($buy_deal_approval));

        return response()->json($buy_deal_approval, 200);
    }
}
