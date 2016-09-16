<?php

namespace App\Http\Controllers;

use App\Model\Mine;

use Illuminate\Http\Request;

use App\Http\Requests;

class MineController extends Controller
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
        $Mine = Mine::where('status', 'a')->get();

        return response()->json($Mine, 200);
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

        $Mine = new Mine();
        $Mine->name = $request->name;
        $Mine->image = $request->image;
        $Mine->title = $request->title;
        $Mine->email = $request->email;
        $Mine->phone = $request->phone;
        $Mine->save();

        return response()->json($Mine, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Mine $Mine)
    {
        if($Mine->status == 'a') {
            return response()->json($Mine, 200);
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
    public function update(Request $request, Mine $Mine)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$Mine) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Mine->name = $request->name;
        $Mine->image = $request->image;
        $Mine->title = $request->title;
        $Mine->email = $request->email;
        $Mine->phone = $request->phone;

        $Mine->save();

        return response()->json($Mine, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mine $Mine)
    {
        if (!$Mine) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Mine->status = 'x';
        $Mine->save();

        return response()->json($Mine, 200);
    }
}
