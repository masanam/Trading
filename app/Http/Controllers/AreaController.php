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
      $areas = $areas->where('description','LIKE','%'.$param.'%');
    }
    $areas = $areas->get();
    
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
    if(!$req) {
      return response()->json([
        'message' => 'Bad Request'
      ], 400);
    }

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

  /**
  * Attach specified resource to a company
  *
  * @param  int  $id
  * @param  int  $contact_id; $concession_id; $product_id; $factory_id; $port_id
  * @return \Illuminate\Http\Response
  */
  public function attach(Request $req, $id)
  {
    if($req->contact_id){
      $items['contact'] = Contact::find($req->contact_id);
      
      if($items['contact']->company_id == $id){
        $items['contact']->status = 'a';  
      } else {
        $items['contact'] = $items['contact']->replicate();  
        $items['contact']->company_id = $id;
      }
      
      $items['contact']->save();
    }

    if($req->concession_id){
      $items['concession'] = Concession::find($req->concession_id);
      $items['concession']->status = 'a';
      $items['concession']->company_id = $id;
      $items['concession']->save();
    }

    if($req->product_id){
      $items['product'] = Product::find($req->product_id);
      
      if($items['product']->company_id == $id){
        $items['product']->status = 'a';  
      } else {
        $items['product'] = $items['product']->replicate();  
        $items['product']->company_id = $id;
      }
      
      $items['product']->save();
    }

    if($req->factory_id){
      $items['factory'] = Factory::find($req->factory_id);
      $items['factory']->status = 'a';
      $items['factory']->company_id = $id;
      $items['factory']->save();
    }

    if($req->port_id){
      $items['port'] = Port::find($req->port_id);
      $items['port']->companies()->attach($id);
    }

    return response()->json($items, 200);
  }

  /**
  * Detach specified resource from a company
  *
  * @param  int  $id
  * @param  int  $contact_id; $concession_id; $product_id; $factory_id; $port_id
  * @return \Illuminate\Http\Response
  */
  public function detach(Request $req, $id)
  {
    if($req->contact_id){
      $items['contact'] = Contact::find($req->contact_id);
      $items['contact']->status = 'x';
      $items['contact']->save();
    }

    if($req->concession_id){
      $items['concession'] = Concession::find($req->concession_id);
      $items['concession']->status = 'x';
      $items['concession']->save();
    }

    if($req->product_id){
      $items['product'] = Product::find($req->product_id);
      $items['product']->status = 'x';
      $items['product']->save();
    }

    if($req->factory_id){
      $items['factory'] = Factory::find($req->factory_id);
      $items['factory']->status = 'x';
      $items['factory']->save();
    }

    if($req->port_id){
      $items['port'] = Port::find($req->port_id);
      $items['port']->companies()->detach($id);
    }

    return response()->json($items, 200);
  }
}
