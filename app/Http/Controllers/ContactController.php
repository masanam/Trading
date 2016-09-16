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
        $Contact = Contact::where('status', 'a')->get();

        return response()->json($Contact, 200);
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

        $Contact = new Contact();
        
        $Contact->user_id = $request->user_id  ? $request->user_id : NULL;
        $Contact->buyer_id = $request->buyer_id  ? $request->buyer_id : NULL;
        $Contact->seller_id = $request->seller_id  ? $request->seller_id : NULL;

        $Contact->name = $request->name;
        $Contact->phone = $request->phone;
        $Contact->email = $request->email;
        $Contact->save();

        return response()->json($Contact, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $Contact)
    {
        if($Contact->status == 'a') {
            return response()->json($Contact, 200);
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
    public function update(Request $request, Contact $Contact)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$Contact) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Contact->user_id = $request->user_id  ? $request->user_id : NULL;
        $Contact->buyer_id = $request->buyer_id  ? $request->buyer_id : NULL;
        $Contact->seller_id = $request->seller_id  ? $request->seller_id : NULL;

        $Contact->name = $request->name;
        $Contact->phone = $request->phone;
        $Contact->email = $request->email;
        $Contact->save();

        return response()->json($Contact, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $Contact)
    {
        if (!$Contact) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $Contact->status = 'x';
        $Contact->save();

        return response()->json($Contact, 200);
    }
}
