<?php

namespace App\Http\Controllers;

use App\Model\SalesTarget;
use App\Model\Product;
use App\Model\ProductVariant;
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

        $products = ProductVariant::with(['sales_target' => function($q) use ($year) {
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
                $sales_target = new SalesTarget();
                if(isset($product->sales_target[$i])) {
                    $sales_target->month= $i+1;
                    $sales_target->price= $product->sales_target[$i]->price;
                    $sales_target->tonnage= $product->sales_target[$i]->tonnage;
                }
                else {
                    $sales_target->month= $i+1;
                    $sales_target->tonnage= 0;
                    $sales_target->price= 0;
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

    public function indexSalesTarget($year, $month)
    {
      if($month) $salestarget = SalesTarget::where('month',$month)->where('year',$year)->get();
      else $salestarget = SalesTarget::where('year',$year)->get();

      $total = 0;
      foreach ($salestarget as $s) {
        $total = $total+$s->tonnage;
      }
      return response()->json(['total' => $total], 200);
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
                // $sales_target->price = $s['price'];
                // $sales_target->save();
                // SalesTarget::updateOrCreate(['product_id' => $st['id'],
                //         'month' => $s['month'],
                //         'year' => $req->year,
                //         'price' => $s['price']], [
                //             'product_id' => $st['id'],
                //             'month' => $s['month'],
                //             'year' => $req->year
                //         ]);

                // DB::statement('insert into sales_target (product_id, month, year, price) prices ('.$st['id'].','.$s['month'].','.$req->year.','.$s->price.') ON DUPLICATE update sales_target set price='.$s->price.' where product_id='.$st['id'].', month='.$s['month'].', year='.$req->year);
                DB::statement('
                    insert into sales_target (`product_variant_id`, `month`, `year`, `tonnage`, `price`)
                    values ('.$st['id'].','.$s['month'].','.$req->year.','.$s['tonnage'].','.$s['price'].')
                    ON DUPLICATE KEY UPDATE `tonnage`='.$s['tonnage'].', `price`='.$s['price'].';');


            }
        }
        return $this->index($year);
    }

}
