<?php

namespace App\Http\Controllers;

use App\Model\Contract;
use App\Model\Order;

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
      $contracts = Contract::with('shipments')->where('status', 'a');
      if($req->unscheduled) {
        $contracts = $contracts->has('shipments', '<' , 1);
      }

      $contracts = $contracts->get();

      return response()->json($contracts, 200);
    }

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
        $contract = Contract::find($id);
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
