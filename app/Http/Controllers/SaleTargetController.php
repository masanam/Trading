<?php

namespace App\Http\Controllers;

use App\Model\SalesTarget;
use Illuminate\Http\Request;

use Auth;


class SaleTargetController extends Controller
{
    public function __construct() {
        $this->middleware(['jwt.auth', 'auth.admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year)
    {
        $st = SalesTarget::with('product')->where('year', $year)->get();
        $sales_target = [];

        foreach($st as $s){
            $sales_target[$s->product_id][$s->month] = $s->value;
        }        
  
        return response()->json([
            'year' => $year,
            'sales_target' => $sales_target
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req, $year)
    {
        foreach($req->sales_target as $product_id => $st){
            foreach ($st as $month => $value) {
                $sales_target = new SalesTarget([
                    'product_id' => $product_id,
                    'year' => $year,
                    'month' => $month,
                    'value' => $value,
                    'updated_by' => Auth::user()
                ]);   

                $sales_target->save();
            }
        }

        return $this->index($year);
    }

}
