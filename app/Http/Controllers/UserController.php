<?php

namespace App\Http\Controllers;

use App\Model\User;

use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth', ['except' => 'store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User = User::where('status', 'a')->get();

        return response()->json($User, 200);
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

        $User = new User();
        $User->name = $request->name;
        $User->image = $request->image;
        $User->title = $request->title;
        $User->email = $request->email;
        $User->phone = $request->phone;
        $User->password = bcrypt($request->password);

        $User->role = 'user';

        $User->status = 'a';

        $User->save();

        return response()->json($User, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $User)
    {
        if($User->status == 'a') {
            return response()->json($User, 200);
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
    public function update(Request $request, User $User)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$User) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $User->name = $request->name;
        $User->image = $request->image;
        $User->title = $request->title;
        $User->email = $request->email;
        $User->phone = $request->phone;
        $User->password = bcrypt($request->password);

        $User->role = $request->role ? $request->role : 'user';

        $User->status = 'a';

        $User->save();

        return response()->json($User, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $User)
    {
        if (!$User) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $User->status = 'x';
        $User->save();

        return response()->json($User, 200);
    }
}
