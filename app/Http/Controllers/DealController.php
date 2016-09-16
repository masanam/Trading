<?php

namespace App\Http\Controllers;

use App\Model\Deal;

use Illuminate\Http\Request;

use App\Http\Requests;

class DealController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Deal = Deal::where('status', 'a')->get();

        return response()->json($Deal, 200);
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

        $Deal = new Deal();
        $Deal->save();

        return response()->json($Deal, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Deal $Deal)
    {
        if($Deal->status == 'a') {
            return response()->json($Deal, 200);
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
    public function update(Request $request, Deal $Deal)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$Deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        // $Deal->save();

        return response()->json($Deal, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deal $Deal)
    {
        if (!$Deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Deal->status = 'x';
        $Deal->save();

        return response()->json($Deal, 200);
    }
}
