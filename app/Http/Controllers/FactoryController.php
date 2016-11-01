<?php

namespace App\Http\Controllers;

use App\Model\Factory;
use App\Model\Buyer;
use App\Model\Product;
use App\Model\Port;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Events\InputEditCoalpedia;

use Illuminate\Support\Facades\DB;

class FactoryController extends Controller
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
        $factory = Factory::where('status', 'a')->get();

        return response()->json($factory, 200);
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

        $factory = new Factory();
        $factory->factory_name = $request->factory_name;
        $factory->buyer_id = $request->buyer_id;
        $factory->owner = $request->owner;
        $factory->address = $request->address;
        $factory->city = $request->city;
        $factory->country = $request->country;
        $factory->latitude = $request->latitude;
        $factory->longitude = $request->longitude;
        $factory->size = $request->size;
        $factory->consumption = $request->consumption;
        $factory->port_id = $request->port_id;
        $factory->port_distance = $request->port_distance;
        $factory->status = 'a';
        $factory->save();

        // event(new InputEditCoalpedia(Auth::user(), $factory->id, 'factory', 'create'));

        return response()->json($factory, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($factory)
    {
        $factory = Factory::find($factory);

        if($factory->status == 'a') {
            return response()->json($factory, 200);
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
    public function update(Request $request, $factory)
    {
        $factory = Factory::find($factory);

        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$factory) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $factory->factory_name = $request->factory_name;
        $factory->buyer_id = $request->buyer_id;
        $factory->owner = $request->owner;
        $factory->address = $request->address;
        $factory->city = $request->city;
        $factory->country = $request->country;
        $factory->latitude = $request->latitude;
        $factory->longitude = $request->longitude;
        $factory->size = $request->size;
        $factory->consumption = $request->consumption;
        $factory->port_id = $request->port_id;
        $factory->port_distance = $request->port_distance;

        $factory->save();

        // event(new InputEditCoalpedia(Auth::user(), $factory->id, 'factory', 'update'));

        return response()->json($factory, 200);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $factory = Factory::find($id);
      
        if (!$id) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $factory = DB::table('factory')->where('id', $id)->update(['status' => 'x']);

        return response()->json($factory, 200);
    }



    public function getTotalFactory() {
        $total = Factory::count();
        $status = array('count' => $total);        
        return response()->json($status, 200);
    }

    public function findMyFactory($id)
    {
        $factory = Factory::where('status', 'a')->where('buyer_id', $id)->get();
        foreach ($factory as $fac) {
            $fac->latitude = floatval($fac->latitude);
            $fac->longitude = floatval($fac->longitude);
        }

        return response()->json($factory, 200);
    }
}
