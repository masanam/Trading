<?php

namespace App\Http\Controllers;

use App\Model\SaleTarget;

use Illuminate\Http\Request;

use App\Http\Requests;

class SaleTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales_target = SaleTarget::with('product')->get();
        return response()->json($sales_target, 200);
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
        if(!$req) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        $sales_target = new SaleTarget($req->only([
            'product_id', 'month', 'year', 'value', 'updated_by'
        ]));
        
        $sales_target->status = 'a';

        $sales_target->save();

        return response()->json($sales_target, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales_target = SaleTarget::with('product')->find($id);

        if($sales_target->status != 'a')
          return response()->json(['message' => 'deactivated record'], 404);
        
        return response()->json($sales_target, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $sales_target)
    {
        $sales_target = SaleTarget::find($sales_target);

        if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
        if (!$sales_target) return response()->json([ 'message' => 'Not found' ] ,404);

        $sales_target->fill($req->only(['month', 'year', 'value', 'updated_by']))->save();

        return response()->json($sales_target, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales_target = SaleTarget::find($id);

        if (!$sales_target) {
          return response()->json([
            'message' => 'Not found'
          ] ,404);
        }

        $sales_target->status = 'x';
        $sales_target->save();

        return response()->json($sales_target, 200);
    }
}
