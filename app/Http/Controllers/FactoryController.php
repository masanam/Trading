<?php

namespace App\Http\Controllers;

use App\Model\Factory;
use App\Model\Buyer;
use App\Model\Product;
use App\Model\Port;
use Auth;

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
    public function index(Request $req)
    {
      if($req->company_id){
        if($req->coalpedia)
            $factory = Factory::where('status', 'a')->where('company_id', '!=', $req->company_id)->get();
        else
            $factory = Factory::where('status', 'a')->where('company_id', $req->company_id)->get();
        foreach ($factory as $fac) {
          $fac->latitude = floatval($fac->latitude);
          $fac->longitude = floatval($fac->longitude);
        }
      }
      else{
        $factory = Factory::where('status', 'a');
        if($req->q) $factory->where('factory_name', 'LIKE', '%' . $req->q . '%');
        $factory = $factory->get();
      }

      return response()->json($factory, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        if(!$req) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        $factory = new Factory($req->only([
            'owner', 'address', 'city', 'country', 'latitude', 'longitude',
            'size', 'consumption', 'port_id', 'port_distance', 'factory_name'
        ]));

        $factory->company_id = $req->company_id;
        $factory->status = 'a';
        $factory->save();

        event(new InputEditCoalpedia(Auth::user(), $factory->id, 'factory', 'create'));

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
        $factory = Factory::with('port', 'company')->findOrFail($factory);
        if($factory->status != 'a') return response()->json(['message' => 'deactivated record'], 404);

        return response()->json($factory, 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $factory = Factory::find($id);

        if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
        if (!$factory) return response()->json([ 'message' => 'Not found' ] ,404);

        $factory->fill($req->only([
            'owner', 'address', 'city', 'country', 'latitude', 'longitude',
            'size', 'consumption', 'port_id', 'port_distance', 'factory_name'
        ]));

        $factory->company_id = $req->company_id;
        $factory->save();

        event(new InputEditCoalpedia(Auth::user(), $factory->id, 'factory', 'update'));

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
        $factory = Factory::where('status', 'a')->where('company_id', $id)->get();
        foreach ($factory as $fac) {
            $fac->latitude = floatval($fac->latitude);
            $fac->longitude = floatval($fac->longitude);
        }

        return response()->json($factory, 200);
    }
}
