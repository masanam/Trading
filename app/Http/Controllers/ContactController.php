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
        $Contact = Contact::get();

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
        $Contact->name = $request->name;
        $Contact->image = $request->image;
        $Contact->title = $request->title;
        $Contact->email = $request->email;
        $Contact->phone = $request->phone;
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
        return response()->json($Contact, 200);
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

        $Contact->name = $request->name;
        $Contact->image = $request->image;
        $Contact->title = $request->title;
        $Contact->email = $request->email;
        $Contact->phone = $request->phone;

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
