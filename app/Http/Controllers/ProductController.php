<?php

namespace App\Http\Controllers;

use App\Model\Product;

use Illuminate\Http\Request;

use App\Http\Requests;

class ProductController extends Controller
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
        $product = Product::where('status', 'a')->get();

        return response()->json($product, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($search = false)
    {
        if (!$search) {
            $product = Product::where('status', 'a')->get();
        } else {
            $product = Product::where('status', 'a')->where('product_name', 'LIKE', '%'.$search.'%')->get();
        }

        return response()->json($product, 200);
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
                'message' => 'Bad Request'
            ], 400);
        }

        $product = new Product();
        $product->seller_id = $request->seller_id ? $request->seller_id : NULL;
        $product->buyer_id = $request->buyer_id ? $request->buyer_id : NULL;
        $product->concession_id = $request->concession_id ? $request->concession_id : NULL;
        //$product->commercial_term = $request->commercial_term;
        $product->product_name = $request->product_name;
        /*$product->ready_date = $request->ready_date;
        $product->expired_date = $request->expired_date;*/
        $product->gcv_arb_min = $request->gcv_arb_min;
        $product->gcv_arb_max = $request->gcv_arb_max;
        /*$product->gcv_arb_reject = $request->gcv_arb_reject;
        $product->gcv_arb_bonus = $request->gcv_arb_bonus;*/
        $product->gcv_adb_min = $request->gcv_adb_min;
        $product->gcv_adb_max = $request->gcv_adb_max;
        /*$product->gcv_adb_reject = $request->gcv_adb_reject;
        $product->gcv_adb_bonus = $request->gcv_adb_bonus;*/
        $product->ncv_min = $request->ncv_min;
        $product->ncv_max = $request->ncv_max;
        /*$product->ncv_reject = $request->ncv_reject;
        $product->ncv_bonus = $request->ncv_bonus;*/
        $product->ash_min = $request->ash_min;
        $product->ash_max = $request->ash_max;
        /*$product->ash_reject = $request->ash_reject;
        $product->ash_bonus = $request->ash_bonus;*/
        $product->ts_min = $request->ts_min; 
        $product->ts_max = $request->ts_max;
        /*$product->ts_reject = $request->ts_reject;
        $product->ts_bonus = $request->ts_bonus;*/
        $product->tm_min = $request->tm_min;
        $product->tm_max = $request->tm_max;
        /*$product->tm_reject = $request->tm_reject;
        $product->tm_bonus = $request->tm_bonus;*/
        $product->im_min = $request->im_min; 
        $product->im_max = $request->im_max;
        /*$product->im_reject = $request->im_reject;
        $product->im_bonus = $request->im_bonus;*/
        $product->fc_min = $request->fc_min; 
        $product->fc_max = $request->fc_max;
        /*$product->fc_reject = $request->fc_reject;
        $product->fc_bonus = $request->fc_bonus;*/
        $product->vm_min = $request->vm_min; 
        $product->vm_max = $request->vm_max;
        /*$product->vm_reject = $request->vm_reject;
        $product->vm_bonus = $request->vm_bonus;*/
        $product->hgi_min = $request->hgi_min;
        $product->hgi_max = $request->hgi_max;
        /*$product->hgi_reject = $request->hgi_reject;
        $product->hgi_bonus = $request->hgi_bonus;*/
        $product->size_min = $request->size_min;
        $product->size_max = $request->size_max;
        $product->fe203_min = $request->fe203_min;
        $product->fe203_max = $request->fe203_max;
        $product->aft_min = $request->aft_min;
        $product->aft_max = $request->aft_max;

        /*$product->size_reject = $request->size_reject;
        $product->size_bonus = $request->size_bonus;
        $product->volume = $request->volume;*/
        $product->status = 'a';
        $product->save();

        return response()->json($product, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        $product = Product::find($product);

        if($product->status == 'a') {
            return response()->json($product, 200);
        } else {
            return response()->json(['message' => 'deactivated record'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product)
    {
        $product = Product::find($product);

        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$product) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $product->seller_id = $request->seller_id ? $request->seller_id : NULL;
        $product->buyer_id = $request->buyer_id ? $request->buyer_id : NULL;
        $product->concession_id = $request->concession_id ? $request->concession_id : NULL;
        //$product->commercial_term = $request->commercial_term;
        $product->product_name = $request->product_name;
        /*$product->ready_date = $request->ready_date;
        $product->expired_date = $request->expired_date;*/
        $product->gcv_arb_min = $request->gcv_arb_min;
        $product->gcv_arb_max = $request->gcv_arb_max;
        /*$product->gcv_arb_reject = $request->gcv_arb_reject;
        $product->gcv_arb_bonus = $request->gcv_arb_bonus;*/
        $product->gcv_adb_min = $request->gcv_adb_min;
        $product->gcv_adb_max = $request->gcv_adb_max;
        /*$product->gcv_adb_reject = $request->gcv_adb_reject;
        $product->gcv_adb_bonus = $request->gcv_adb_bonus;*/
        $product->ncv_min = $request->ncv_min;
        $product->ncv_max = $request->ncv_max;
        /*$product->ncv_reject = $request->ncv_reject;
        $product->ncv_bonus = $request->ncv_bonus;*/
        $product->ash_min = $request->ash_min;
        $product->ash_max = $request->ash_max;
        /*$product->ash_reject = $request->ash_reject;
        $product->ash_bonus = $request->ash_bonus;*/
        $product->ts_min = $request->ts_min; 
        $product->ts_max = $request->ts_max;
        /*$product->ts_reject = $request->ts_reject;
        $product->ts_bonus = $request->ts_bonus;*/
        $product->tm_min = $request->tm_min;
        $product->tm_max = $request->tm_max;
        /*$product->tm_reject = $request->tm_reject;
        $product->tm_bonus = $request->tm_bonus;*/
        $product->im_min = $request->im_min; 
        $product->im_max = $request->im_max;
        /*$product->im_reject = $request->im_reject;
        $product->im_bonus = $request->im_bonus;*/
        $product->fc_min = $request->fc_min; 
        $product->fc_max = $request->fc_max;
        /*$product->fc_reject = $request->fc_reject;
        $product->fc_bonus = $request->fc_bonus;*/
        $product->vm_min = $request->vm_min; 
        $product->vm_max = $request->vm_max;
        /*$product->vm_reject = $request->vm_reject;
        $product->vm_bonus = $request->vm_bonus;*/
        $product->hgi_min = $request->hgi_min;
        $product->hgi_max = $request->hgi_max;
        /*$product->hgi_reject = $request->hgi_reject;
        $product->hgi_bonus = $request->hgi_bonus;*/
        $product->size_min = $request->size_min;
        $product->size_max = $request->size_max;
        $product->fe203_min = $request->fe203_min;
        $product->fe203_max = $request->fe203_max;
        $product->aft_min = $request->aft_min;
        $product->aft_max = $request->aft_max;
        /*$product->size_reject = $request->size_reject;
        $product->size_bonus = $request->size_bonus;
        $product->volume = $request->volume;*/

        $product->save();

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        $product = Product::find($product);
     
        if (!$product) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $product->status = 'x';
        $product->save();

        return response()->json($product, 200);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyByID($id)
    {
        $product = Product::find($id);
     
        if (!$product) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $product->status = 'x';
        $product->save();

        return response()->json($product, 200);
    }

    public function getTotalProduct() {
        $total = Product::count();
        $status = array('count' => $total);        
        return response()->json($status, 200);
    }

    public function findMyProductBuyer($id)
    {
        $product = Product::where('status', 'a')->where('buyer_id', $id)->get();

        return response()->json($product, 200);
    }

    public function findMyProductSeller($id)
    {
        $product = Product::where('status', 'a')->where('seller_id', $id)->get();

        return response()->json($product, 200);
    }
}
