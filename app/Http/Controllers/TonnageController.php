<?php

namespace App\Http\Controllers;

use App\Model\Tonnage;
use App\Model\TonnageHistory;

use Illuminate\Http\Request;

use App\Http\Requests;

class TonnageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tonnage = Tonnage::with('product')->get();
        return response()->json($tonnage, 200);
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

        $tonnage = new Tonnage($req->only([
            'product_id', 'month', 'year', 'value', 'updated_by'
        ]));
        
        $tonnage->status = 'a';

        $tonnage->save();

        return response()->json($tonnage, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tonnage = Tonnage::with('product')->find($id);

        if($tonnage->status != 'a')
          return response()->json(['message' => 'deactivated record'], 404);
        
        return response()->json($tonnage, 200);
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
    public function update(Request $req, $tonnage)
    {
        $tonnage = Tonnage::find($tonnage);

        if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
        if (!$tonnage) return response()->json([ 'message' => 'Not found' ] ,404);

        $tonnage->fill($req->only(['month', 'year', 'value', 'updated_by']))->save();

        return response()->json($tonnage, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tonnage = Tonnage::find($id);

        if (!$tonnage) {
          return response()->json([
            'message' => 'Not found'
          ] ,404);
        }

        $tonnage->status = 'x';
        $tonnage->save();

        return response()->json($tonnage, 200);
    }
}
