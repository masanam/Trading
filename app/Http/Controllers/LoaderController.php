<?php

namespace App\Http\Controllers;

use App\Model\Shipment;
use App\Model\Loader;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class LoaderController extends Controller
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
        $loader = Loader::with('shipment')->where('status', 'a');

        if($req->q) {
          $param = $req->q;
          $loader = $loader->where('loader_name', 'LIKE', '%'.$param.'%');
        }
       
        return response()->json($loader->get(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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

        $loader = new Loader();
        $loader->loader_name = $req->loader_name;        
        $loader->status = 'a';
        $loader->save();

        return response()->json($loader, 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vessel  $vessel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loader = Loader::with('shipment')->find($id);
        return response()->json($loader, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vessel  $vessel
     * @return \Illuminate\Http\Response
     */
    public function edit(Vessel $vessel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductVariant  $productVarint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $loader)
    {
        $loader = Loader::find($loader);

        if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
        if (!$loader) return response()->json([ 'message' => 'Not found' ] ,404);

        $loader->loader_name = $req->loader_name;

        $loader->save();

        return response()->json($loader, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loader = Loader::where('status', 'a')->find($id);

        if (!$loader) return response()->json([ 'message' => 'Not found or Deactivated Loader' ] ,404);

        $loader->status = 'x';
        $loader->save();

        return response()->json($loader, 200);
    }
}
