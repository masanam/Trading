<?php

namespace App\Http\Controllers;

use App\Model\ProductionPlan;
use App\Model\Product;
use App\Model\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use Auth;
use DB;


class ProductionPlanController extends Controller
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
        // $st = ProductionPlan::with('product')
        //             ->where('year', $year)
        //             ->whereHas('product', function($q) {
        //                 $q->where('company_id', config('housecompany'));
        //             })->get();

        $products = ProductVariant::with(['production_plan' => function($q) use ($year) {
                      $q->where('year', $year);
                    }, 'product'])
                    ->whereHas('product', function($q) {
                      $q->where('company_id', config('housecompany'));
                    })
                    ->where('status', 'a')
                    ->select('id', 'name_product_variant')
                    ->get();

        // echo $st;
        foreach ($products as $product) {
            $sales_array = [];
            for ($i=0; $i < 12; $i++) {
                $production_plan = new ProductionPlan();
                if(isset($product->production_plan[$i])) {
                    $production_plan->month= $i+1;
                    $production_plan->price= $product->production_plan[$i]->price;
                    $production_plan->tonnage= $product->production_plan[$i]->tonnage;
                }
                else {
                    $production_plan->month= $i+1;
                    $production_plan->tonnage= 0;
                    $production_plan->price= 0;
                }
                array_push($sales_array, $production_plan);
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
        $production_plan = $req->target;
        foreach($req->target as $st){
            foreach ($st['sales'] as $s) {
                // $production_plan = new ProductionPlan();
                // $production_plan->product_id = $st['id'];
                // $production_plan->month = $s['month'];
                // $production_plan->year = $req->year;
                // $production_plan->price = $s['price'];
                // $production_plan->save();
                // ProductionPlan::updateOrCreate(['product_id' => $st['id'],
                //         'month' => $s['month'],
                //         'year' => $req->year,
                //         'price' => $s['price']], [
                //             'product_id' => $st['id'],
                //             'month' => $s['month'],
                //             'year' => $req->year
                //         ]);

                // DB::statement('insert into production_plan (product_id, month, year, price) prices ('.$st['id'].','.$s['month'].','.$req->year.','.$s->price.') ON DUPLICATE update production_plan set price='.$s->price.' where product_id='.$st['id'].', month='.$s['month'].', year='.$req->year);
                DB::statement('
                    insert into production_plan (`product_variant_id`, `month`, `year`, `tonnage`, `price`)
                    values ('.$st['id'].','.$s['month'].','.$req->year.','.$s['tonnage'].','.$s['price'].')
                    ON DUPLICATE KEY UPDATE `tonnage`='.$s['tonnage'].', `price`='.$s['price'].';');


            }
        }
        return $this->index($year);
    }

}
