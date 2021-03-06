<?php

namespace App\Http\Controllers;

use App\Model\Port;
use App\Model\Company;
use App\Model\BuyerPort;
use App\Model\SellerPort;
use App\Model\Factory;
use App\Model\Concession;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class PortController extends Controller
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
        $limit = $req->limit | 10;

        $port = Port::with(['companies' => function ($query) {
            // $query->select('id','company_name','company_id','owner','reserves','city','country');
            $query->where('company_type', 'c');
          }])->with('factories')->limit($limit);
        $port_id = Company::with('ports')->where('id', $req->company_id)->get();
        $port_id = $port_id->pluck('ports');
        foreach ($port_id as $p) {
            $port_id = $p->pluck('id');
        }
        if($req->q) $port->where('port_name', 'LIKE', '%' . $req->q . '%');
        if($port_id) $port->whereNotIn('id', $port_id);

        return response()->json($port->get(), 200);
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

        $port = new Port($req->only([
            'port_name', 'owner', 'is_private', 'location', 'size',
            'river_capacity', 'address', 'latitude', 'longitude','anchorage_distance',
            'has_conveyor', 'has_crusher', 'has_blending', 'draft_height','daily_discharge_rate'
        ]));

        $port->status = 'a';
        $port->save();
        $port->companies()->attach($req->company_id);

        return response()->json($port, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $port = Port::with(['concessions'=> function ($query) {
        //     $query->select('id','concession_name','company_id','owner','reserves','city','country');
        //   }])->find($id);

        $port = Port::with(['companies' => function ($query) {
            // $query->select('id','company_name','company_id','owner','reserves','city','country');
            $query->where('company_type', 'c');
          }])->with('factories')->find($id);

        return response()->json($port, 200);
    //}

    // public function connectedConcessions($id) {
    //     $connectedConcessions = Concession::where('port_id', $id)->get();
    //
    //     return response()->json($connectedConcessions, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $port)
    {
       $port = Port::find($port);

        if (!$req) return response()->json(['message' => 'Bad Request'], 400);
        if (!$port) return response()->json(['message' => 'Not found'] ,404);

        $port->fill($req->only([
            'port_name', 'owner', 'is_private', 'location', 'size',
            'river_capacity', 'address', 'latitude', 'longitude','anchorage_distance',
            'has_conveyor', 'has_crusher', 'has_blending', 'draft_height','daily_discharge_rate'
        ]));

        $port->save();

        return response()->json($port, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $port = Port::findOrFail($id);
        $port->status = 'x';
        $port->save();

        return response()->json($port, 200);
    }

    public function attach($company_id, $id)
    {
        $port = Port::find($id);
        $port->companies()->attach($company_id);

        return response()->json($port, 200);
    }

    public function detach($company_id, $id)
    {
        $port = Port::find($id);
        $port->buyers()->detach($company_id);

        $factory = Factory::where('port_id',$id)
            ->where('company_id', $company_id)->get();
        $concession = Concession::where('port_id',$id)
            ->where('company_id', $company_id)->get();

        foreach ($factory as $item ) {
            $item->port_id = null;
            $item->port_distance = null;
            $item->save();
        }
        foreach ($concession as $item ) {
            $item->port_id = null;
            $item->port_distance = null;
            $item->save();
        }

        return response()->json($port, 200);
    }
}
