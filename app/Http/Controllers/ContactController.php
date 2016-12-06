<?php

namespace App\Http\Controllers;

use App\Model\Contact;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
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
    $contact = Contact::where('status', 'a');
    
    if($req->q) $contact->where('name', 'LIKE', '%'.$req->q.'%');

    return response()->json($contact->get(), 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $contact = Contact::find($id);

    if($contact->status != 'a')
      return response()->json(['message' => 'deactivated record'], 404);
    
    return response()->json($contact, 200);
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

    $contact = new Contact($req->only(['name', 'phone', 'email']));
    
    $contact->user_id = $req->user_id  ? $req->user_id : NULL;
    $contact->company_id = $req->company_id  ? $req->company_id : NULL;
    $contact->status = 'a';
    $contact->save();

    return response()->json($contact, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $req
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $req, $contact)
  {
    $contact = Contact::find($contact);

    if (!$req) return response()->json([ 'message' => 'Bad Request' ], 400);
    if (!$contact) return response()->json([ 'message' => 'Not found' ] ,404);

    $contact->user_id = $req->user_id  ? $req->user_id : NULL;
    $contact->company_id = $req->company_id  ? $req->company_id : NULL;

    $contact->fill($req->only(['name', 'phone', 'email']))->save();

    return response()->json($contact, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $contact = Contact::where('status', 'a')->find($id);
    
    if (!$contact) return response()->json([ 'message' => 'Not found or Deactivated Contact' ] ,404);

    $contact = DB::table('contacts')->where('id', $id)->update(['status' => 'x']);

    return response()->json($contact, 200);
  }
}
