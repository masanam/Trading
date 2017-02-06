<?php

namespace App\Http\Controllers;

use App\Model\SalesTarget;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use Auth;
use DB;


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
        $year = $req->year;
        $sales_target = $req->target;
        foreach($req->target as $st){
            foreach ($st['sales'] as $s) {
                // $sales_target = new SalesTarget();
                // $sales_target->product_id = $st['id'];
                // $sales_target->month = $s['month'];
                // $sales_target->year = $req->year;
                // $sales_target->value = $s['value'];
                // $sales_target->save();
                // SalesTarget::updateOrCreate(['product_id' => $st['id'],
                //         'month' => $s['month'],
                //         'year' => $req->year,
                //         'value' => $s['value']], [
                //             'product_id' => $st['id'],
                //             'month' => $s['month'],
                //             'year' => $req->year
                //         ]); 

                // DB::statement('insert into sales_target (product_id, month, year, value) values ('.$st['id'].','.$s['month'].','.$req->year.','.$s->value.') ON DUPLICATE update sales_target set value='.$s->value.' where product_id='.$st['id'].', month='.$s['month'].', year='.$req->year);
                DB::statement('
                    insert into sales_target (`product_id`, `month`, `year`, `value`) 
                    values ('.$st['id'].','.$s['month'].','.$req->year.','.$s['value'].')
                    ON DUPLICATE KEY UPDATE `value`='.$s['value'].';');






            }
        }
        return $this->index($year);
    }

}
