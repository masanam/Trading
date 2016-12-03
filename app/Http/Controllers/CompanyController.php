<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\Contact;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\BuyOder;

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
    $companies = Company::with('user')->where('status', 'a');

    if($req->q) $companies->where('company_name', 'LIKE', '%'.$req->q.'%');
    if($req->type) $companies->where('company_type', $req->type[0]);

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
    $company = Company::with(['contacts','products','factories','ports','concessions','user'])->find($id);

    if($company->status == 'a') {
      return response()->json($company, 200);
    } else {
      return response()->json(['message' => 'deactivated record'], 404);
    }
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $req
  * @return \Illuminate\Http\Response
  */
  public function store(Request $req, $type)
  {
    if(!$req) {
      return response()->json([
        'message' => 'Bad Request'
      ], 400);
    }

    $company = new Buyer($req->all());
    $company->user_id = Auth::user()->id;
    $company->company_type = $type[0];
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
    $company = Buyer::find($id);

    if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
    if (!$company) return response()->json([ 'message' => 'Not found' ] ,404);

    $company->fill($req->all())->save();

    event(new InputEditCoalpedia(Auth::user(), $company->id, 'companies', 'update'));
    return response()->json($company, 200);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $company = Buyer::find($id);

    if (!$company) return response()->json([ 'message' => 'Not found' ] ,404);

    $company->status = 'x';
    $company->save();

    return response()->json($company, 200);
  }
}
