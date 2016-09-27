<?php

namespace App\Http\Controllers;

use App\Model\User;

use Illuminate\Http\Request;
use Auth;

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
        $user = User::where('status', 'a')->get();

        return response()->json($user, 200);
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

        $user = new User();
        $user->name = $request->name;
        $user->image = $request->image;
        $user->title = $request->title;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);

        $user->role = 'user';

        $user->status = 'a';

        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if($user->status == 'a') {
            return response()->json($user, 200);
        } else {
            return response()->json(['message' => 'deactivated record'], 404);
        }    
    }

    public function currentUser() {
        return response()->json(Auth::user(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$user) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $user->name = $request->name;
        $user->image = $request->image;
        $user->title = $request->title;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);

        $user->role = $request->role ? $request->role : 'user';

        $user->status = 'a';

        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!$user) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $user->status = 'x';
        $user->save();

        return response()->json($user, 200);
    }
}
