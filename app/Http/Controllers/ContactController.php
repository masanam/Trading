<?php

namespace App\Http\Controllers;

use App\Model\Contact;

use Illuminate\Http\Request;

use App\Http\Requests;

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
    public function index()
    {
        $contact = Contact::where('status', 'a')->get();

        return response()->json($contact, 200);
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

        $contact = new Contact();
        
        $contact->user_id = $request->user_id  ? $request->user_id : NULL;
        $contact->buyer_id = $request->buyer_id  ? $request->buyer_id : NULL;
        $contact->seller_id = $request->seller_id  ? $request->seller_id : NULL;

        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->save();

        return response()->json($contact, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        if($contact->status == 'a') {
            return response()->json($contact, 200);
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
    public function update(Request $request, Contact $contact)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$contact) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $contact->user_id = $request->user_id  ? $request->user_id : NULL;
        $contact->buyer_id = $request->buyer_id  ? $request->buyer_id : NULL;
        $contact->seller_id = $request->seller_id  ? $request->seller_id : NULL;

        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->save();

        return response()->json($contact, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        if (!$contact) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $contact->status = 'x';
        $contact->save();

        return response()->json($contact, 200);
    }
}
