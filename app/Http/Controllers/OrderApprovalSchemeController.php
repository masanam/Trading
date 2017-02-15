<?php

namespace App\Http\Controllers;

use App\Model\OrderApprovalScheme;
use App\Model\OrderApprovalSchemeSequence;

use Illuminate\Http\Request;

use App\Http\Requests;

class OrderApprovalSchemeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
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

      foreach ($req->sequences as $s) {
        $seq = null;
        if($s['id']){
          $seq = OrderApprovalSchemeSequence::find($s['id']);
        }else{
          $seq = new OrderApprovalSchemeSequence();
        }
          $seq->order_approval_scheme_id = $scheme->id;
          $seq->sequence = $s['sequence'];
          $seq->role_id = $s['role_id'];
          $seq->approval_scheme = $s['approval_scheme'];
          $seq->save();
      }

          return response()->json($seq, 400);

      return $this->show($id);
    }

    public function destroy($id)
    {
      // $data = QualityDetail::find($id);
     
      // if (!$data) {
      //   return response()->json([
      //     'message' => 'Not found'
      //   ] ,404);
      // }

      // $data->delete();

      // return response()->json(true, 200);
    }

}
