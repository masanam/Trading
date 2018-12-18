<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\Contact;
use App\Model\Concession;
use App\Model\Factory;
use App\Model\Product;
use App\Model\Port;
use App\Model\Area;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Events\InputEditCoalpedia;

class AreaController extends Controller
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
    $areas = Area::where('status', 'a');
    if($req->q){
      $param = $req->q;  
      $areas = $areas->where('area_name','LIKE','%'.$param.'%');
      $areas = $areas->orwhere('description','LIKE','%'.$param.'%');
    }
    $areas = $areas->get();
    // $areas = $areas->paginate(5);
    
    return response()->json($areas, 200);
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $area = Area::where('status', 'a')->find($id);    
    
    return response()->json($area, 200);
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $req
  * @return \Illuminate\Http\Response
  */
  public function store(Request $req)
  {
    $area = new Area($req->all());    
    $area->status = 'a';
    $area->save();

    return response()->json($area, 200);
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
    $area = Area::find($id);

    if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
    if (!$area) return response()->json([ 'message' => 'Not found' ] ,404);

    $area->fill($req->all())->save();

    event(new InputEditCoalpedia(Auth::user(), $area->id, 'areas', 'update'));
    return $this->show($id);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $area = Area::find($id);

    if (!$area) return response()->json([ 'message' => 'Not found' ] ,404);

    $area->status = 'x';
    $area->save();

    return response()->json($area, 200);
  }
}
