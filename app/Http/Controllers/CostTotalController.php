<?php

namespace App\Http\Controllers;

use App\Model\CostHeader;
use App\Model\CostTotal;
use App\Model\MiningLicense;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;

class CostTotalController extends Controller
{
    public function __construct() {
      $this->middleware('jwt.auth');
    }


    public function index(Request $req = null)
    {
    	$cost_total = CostTotal::get();

    	if($req->calculation_id&&$req->mining_license_id){
    		$cost_header = CostHeader::where('calculation_id',$req->calculation_id)->where('mining_license_id',$req->mining_license_id)->first();
    		$cost_total = CostTotal::where('header_id',$cost_header->id)->first();
    	}

        return response()->json($cost_total, 200);
    }

    public function store(Request $req)
    {
        if(!$req) {
          return response()->json([
            'message' => 'Bad Request'
          ], 400);
        }

        $cost_header = CostHeader::where('calculation_id',$req->calculation_id)->where('mining_license_id',$req->mining_license_id)->first();
        //hasapu add
        $license = MiningLicense::with('Concession');
        $license = $license->where('id',$req->mining_license_id)->first();
        //hasapu add end
        $cost_total = CostTotal::where('header_id',$cost_header->id)->first();
        if(!$cost_total) $cost_total = new CostTotal();
        $cost_total->header_id = $cost_header->id;
        $cost_total->total = $req->total;
        $cost_total->cogs = $req->total/$license->Concession->reserves;
        $cost_total->save();

        return response()->json($cost_total, 200);
    }

}
