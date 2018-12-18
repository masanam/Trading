<?php

namespace App\Http\Controllers;

use App\Model\OrderApprovalScheme;
use App\Model\OrderApprovalSchemeSequence;

use Illuminate\Http\Request;
use DB;

use App\Http\Requests;

class OrderApprovalSchemeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req = null)
    {
      $scheme = OrderApprovalScheme::with('sequences','area')->get();

      return response()->json($scheme, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $req)
    {
      $scheme = new OrderApprovalScheme();
      $scheme->order_approval_scheme_name = $req->order_approval_scheme_name;
      $scheme->sell_area_id = $req->sell_area_id;
      $scheme->save();

      foreach ($req->sequences as $s) {
        $seq = new OrderApprovalSchemeSequence();
        $seq->order_approval_scheme_id = $scheme->id;
        $seq->sequence = $s['sequence'];
        $seq->role_id = $s['role_id'];
        $seq->approval_scheme = $s['approval_scheme'];
        $seq->save();
      }

      return response()->json(OrderApprovalScheme::with('sequences','area')->find($scheme->id), 200);
    }

    public function show($id)
    {
      $scheme = OrderApprovalScheme::with('sequences','area')->find($id);

      return response()->json($scheme, 200);
    }

    public function update(Request $req, $id)
    {
      $scheme = OrderApprovalScheme::with('sequences','area')->find($id);
      $scheme->order_approval_scheme_name = $req->order_approval_scheme_name;
      $scheme->sell_area_id = $req->sell_area_id;
      $scheme->save();
      $a = count($req->sequences);
          
      for ($i=0; $i < $a; $i++) { 
        if(!isset($req->sequences[$i]['id'])){
          $seq = new OrderApprovalSchemeSequence();
          $seq->order_approval_scheme_id = $scheme->id;
          $seq->sequence = $req->sequences[$i]['sequence'];
          $seq->role_id = $req->sequences[$i]['role_id'];
          $seq->approval_scheme = $req->sequences[$i]['approval_scheme'];
          $seq->save();
        }
        else{
          DB::table('order_approval_scheme_sequences')
            ->where('id', $req->sequences[$i]['id'])
            ->update(['role_id' => $req->sequences[$i]['role_id'], 
              'approval_scheme' => $req->sequences[$i]['approval_scheme'],
              'order_approval_scheme_id' => $scheme->id,
              'sequence' => $req->sequences[$i]['sequence']]);
        }
      }
      // foreach ($req->sequences as $s) {
      //   if($s['id']){
      //     DB::table('order_approval_scheme_sequences')
      //       ->where('id', $s['id'])
      //       ->update(['role_id' => $s['role_id']]);
      //   }else{
      //     $seq = new OrderApprovalSchemeSequence();
      //     $seq->order_approval_scheme_id = $scheme->id;
      //     $seq->sequence = $s['sequence'];
      //     $seq->role_id = $s['role_id'];
      //     $seq->approval_scheme = $s['approval_scheme'];
      //     $seq->save();
      //   }
      // }

      return $this->show($id);
    }

    public function destroy(Request $req, $order_approval_scheme_id)
    {
      if($req->action === 'scheme'){
        OrderApprovalSchemeSequence::where('order_approval_scheme_id',$order_approval_scheme_id)->delete();
        $data = OrderApprovalScheme::where('id',$order_approval_scheme_id)->delete();
      }
      else{
        $data = OrderApprovalSchemeSequence::where('order_approval_scheme_id',$order_approval_scheme_id)->where('sequence',$req->sequence)->first();
        $data->delete();
      }

      if (!$data) {
        return response()->json([
          'message' => 'Not found'
        ] ,404);
      }

      return response()->json($data, 200);
    }

}
