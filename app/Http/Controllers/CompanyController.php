<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\Contact;
use App\Model\Concession;
use App\Model\Factory;
use App\Model\Product;
use App\Model\Port;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Events\InputEditCoalpedia;

class CompanyController extends Controller
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
    $companies = Company::with('user', 'area', 'ports', 'factories', 'products')->where('status', 'a');
    if($req->keyword) {
      $key = $req->keyword;
      if ($req->keyword == 'c' || $req->keyword == 's') {
        $companies->whereHas('user', function($q) use ($key) {
          $q->whereIn('company_type',[$key, 't']);
        })
        ->orWhereIn('company_type',[$req->keyword, 't']);
      }
      else {
        $companies->whereHas('user', function($q) use ($key) {
          $q->where('company_type', $key);
        })
        ->orWhere('company_type', $req->keyword);
      }
    }
    if($req->keyword && $req->search) {
      $param = $req->search;
      $key = $req->keyword;
      if ($req->keyword == 'c' || $req->keyword == 's') {
        $companies->whereHas('user', function($q) use ($param,$key) {
          $q->where('name', 'LIKE', '%'.$param.'%')->whereIn('company_type',[$key, 't']);
        })
        ->orWhere('company_name', 'LIKE', '%'.$req->search.'%')->whereIn('company_type',[$req->keyword, 't'])
        ->orWhere('phone', 'LIKE', '%'.$req->search.'%')->whereIn('company_type',[$req->keyword, 't'])
        ->orWhere('email', 'LIKE', '%'.$req->search.'%')->whereIn('company_type',[$req->keyword, 't']);
      }
      else {
        $companies->whereHas('user', function($q) use ($param,$key) {
          $q->where('name', 'LIKE', '%'.$param.'%')->where('company_type', $key);
        })
        ->orWhere('company_name', 'LIKE', '%'.$req->search.'%')->where('company_type', $req->keyword)
        ->orWhere('phone', 'LIKE', '%'.$req->search.'%')->where('company_type', $req->keyword)
        ->orWhere('email', 'LIKE', '%'.$req->search.'%')->where('company_type', $req->keyword);
      }
    }

    // $limit = $req->pageSize ? $req->pageSize : 10;
    // $skip = ( $req->pageSize * $req->page ) ? ( $req->pageSize * $req->page ) : 0;



    if($req->type) {
      if ($req->type[0] == 'c' || $req->type[0] == 's')
        $companies->whereIn('company_type', [ $req->type[0], 't' ]);

      else $companies->where('company_type', $req->type[0]);
    }

    if($req->area_id) $companies->where('area_id','=',$req->area_id);

    if($req->company_type){ $companies->where('company_type','=',$req->company_type); }

    if($req->q) {
      $param = $req->q;
      $companies->whereHas('user', function($q) use ($param) {
        $q->where('name', 'LIKE', '%'.$param.'%');
      })
        ->orWhere('company_name', 'LIKE', '%'.$req->q.'%')
        ->orWhere('address', 'LIKE', '%'.$req->q.'%')
        ->orWhere('city', 'LIKE', '%'.$req->q.'%')
        ->orWhere('country', 'LIKE', '%'.$req->q.'%')
        ->orWhere('phone', 'LIKE', '%'.$req->q.'%')
        ->orWhere('email', 'LIKE', '%'.$req->q.'%')
        ->orWhere('industry', 'LIKE', '%'.$req->q.'%');
    }
    

    //for filter country
    if($req->country) $companies->where('country',$req->country);

    $companies = $companies->get();
    return response()->json($companies, 200);
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $company = Company::with(['contacts','products','factories','ports','user','area',
      'concessions' => function ($query) {
        $query->select('id','concession_name','company_id','owner','reserves','city','country');
      },'concessions.port'])->find($id);

    if($company->status != 'a')
      return response()->json(['message' => 'deactivated record'], 404);

    return response()->json($company, 200);
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

    $company = new Company($req->all());
    $company->user_id = Auth::user()->id;
    $company->status = 'a';
    $company->save();

    event(new InputEditCoalpedia(Auth::user(), $company->id, 'companies', 'create'));

    return response()->json($company, 200);
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
    $company = Company::find($id);

    if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
    if (!$company) return response()->json([ 'message' => 'Not found' ] ,404);

    $company->fill($req->all())->save();

    event(new InputEditCoalpedia(Auth::user(), $company->id, 'companies', 'update'));
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
    $company = Company::find($id);

    if (!$company) return response()->json([ 'message' => 'Not found' ] ,404);

    $company->status = 'x';
    $company->save();

    return response()->json($company, 200);
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
