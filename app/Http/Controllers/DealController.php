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
        $deal = Deal::where('status', 'a')->get();

        return response()->json($deal, 200);
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

        $deal = new Deal();
        $deal->save();

        return response()->json($deal, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Deal $deal)
    {
        if($deal->status == 'a') {
            return response()->json($deal, 200);
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
    public function update(Request $request, Deal $deal)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        // $deal->save();

        return response()->json($deal, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deal $deal)
    {
        if (!$deal) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $deal->status = 'x';
        $deal->save();

        return response()->json($deal, 200);
    }
}
