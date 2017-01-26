<?php

namespace App\Http\Controllers;

use App\Model\SalesTarget;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use Auth;


class SalesTargetController extends Controller
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
        // $st = SalesTarget::with('product')
        //             ->where('year', $year)
        //             ->whereHas('product', function($q) {
        //                 $q->where('company_id', config('housecompany'));
        //             })->get();

        $products = Product::with(['sales_target' => function($q) use ($year) {
                        $q->where('year', $year);
                    }])
                    ->where('company_id', config('housecompany'))
                    ->select('id', 'product_name')
                    ->get();
        // echo $st;
        foreach ($products as $product) {
            $sales_array = [];
            for ($i=0; $i < 12; $i++) { 
                $sales_target = new SalesTarget();
                if(isset($product->sales_target[$i])) {
                    $sales_target->month= $i+1;
                    $sales_target->value= $product->sales_target[$i]->value;
                }
                else {
                    $sales_target->month= $i+1;
                    $sales_target->value= 0;
                }
                array_push($sales_array, $sales_target);
            }
            $product->sales = $sales_array;
        }

  
        return response()->json([
            'year' => $year,
            'target' => $products
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
    public function store(Request $req)
    {
        dd($req);

        $year = $req->year;

        /*$sales_target = new SalesTarget($req->all());            
        $sales_target->save();*/
        // foreach($req->sales_target as $product_id => $st){
        //     foreach ($st as $month => $value) {
        //         $sales_target = new SalesTarget([
        //             'product_id' => $product_id,
        //             'year' => $year,
        //             'month' => $month,
        //             'value' => $value,
        //             'updated_by' => Auth::user()
        //         ]);   

        //         $sales_target->save();
        //     }
        // }

        return $this->index($year);
    }

}
