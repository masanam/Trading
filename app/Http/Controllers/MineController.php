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
        $mine = Mine::where('status', 'a')->get();

        return response()->json($mine, 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($search = false)
    {
        if (!$search) {
            $mine = Mine::where('status', 'a')->get();
        } else {
            $mine = Mine::where('status', 'a')->where('mine_name', 'LIKE', '%'.$search.'%')->get();
        }

        return response()->json($mine, 200);
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

        $mine = new Mine();
        $mine->name = $request->name;
        $mine->image = $request->image;
        $mine->title = $request->title;
        $mine->email = $request->email;
        $mine->phone = $request->phone;
        $mine->save();

        return response()->json($mine, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Mine $mine)
    {
        if($mine->status == 'a') {
            return response()->json($mine, 200);
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
    public function update(Request $request, Mine $mine)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$mine) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $mine->name = $request->name;
        $mine->image = $request->image;
        $mine->title = $request->title;
        $mine->email = $request->email;
        $mine->phone = $request->phone;

        $mine->save();

        return response()->json($mine, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mine $mine)
    {
        if (!$mine) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $mine->status = 'x';
        $mine->save();

        return response()->json($mine, 200);
    }



    public function getTotalMine() {
        $total = Mine::count();
        $status = array('count' => $total);        
        return response()->json($status,200);
    }
}
