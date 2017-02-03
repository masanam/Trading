<?php

namespace App\Http\Controllers;

use App\Model\User;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

use App\Events\EditUserProfile;

use App\Http\Requests;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use App\Mail\ForgotPassword;

use Illuminate\Support\Facades\Config;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['store', 'sendResetLinkEmail']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->status) $user = User::where('status', $request->status)->get();
        else $user = User::where('status', 'a')->get();

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
        $user = User::where(['email' => $request->email])->get();
        foreach ($user as  $users) {
            $users=$users['id'];
        }
        if(!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }
        else if(!empty($users)){
            return response()->json([
                'message' => 'Your email is already registered. If you forgot your password, please send an enquiry to info@volantech.io'
            ], 400);
        }

        $user = new User;
        $user->name = trim($request->name);
        $user->title = trim($request->title);
        $user->image = trim($request->image);
        $user->status = 'a';
        $user->email = trim(strtolower($request->email));
        $user->phone = trim($request->phone);
        $user->password = bcrypt($request->password);
        $user->save();

        $user->roles()->attach($request->role);
        

        return response()->json(compact('user'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $user = User::with('directSubordinates','directManager','roles')->find($user);

        if($user->status == 'a') {
            return response()->json($user, 200);
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
    public function update(Request $req, $id)
    {
        $user = User::find($id);

        if (!$req) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$user) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        if($req->direct_subordinates){
            foreach ($req->direct_subordinates as $sub) {
                $temp_sub = User::find($sub['id']);
                $temp_sub->manager_id = $id;
                $temp_sub->save();
            }
        }

        $lastImage = $user->image;

        if($req->old_password && $req->password){
            if(Hash::check($req->old_password, $user->password)) $user->password = bcrypt($req->password);
            else return response()->json(['message' => 'wrong old password'], 400);
        }

        $user->name = $req->name;
        $user->image = $req->image;
        $user->title = $req->title;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->employee_id = $req->employee_id;
        $user->manager_id = $req->manager_id;

        if($req->roles){
            $roles = [];
            foreach($req->roles as $r) {
                $roles[] = $r['id'];
            }

            $user->roles()->sync($roles);
        }

        // if($req->role_id) $user->roles()->attach($req->role_id);
        // $user->role = $req->role ? $req->role : 'user';

        $user->status = 'a';

        $user->save();

        // if the new photo url is not the same with the old one, they've changed their photo
        if($lastImage != $user->image) {
            event(new EditUserProfile($user, 'photo'));
        }

        // regardless of whether they change the photo or not, they still change the profile
        event(new EditUserProfile($user, 'edit'));

        return $this->show($id);
    }

    public function setActing(Request $request, $user) {
        // find the person who want to give the priviledge of acting role
        $user = User::find($user);

        if(!$user) 
            return response()->json([
                'message' => 'Not found'
            ] ,404);

        $user->interims()->attach($request->interim_id, [
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'role' => $request->role,
            'status' => 'a'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $req = null)
    {
        $user = User::with('directSubordinates')->find($id);
        
        if (!$user) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        //remove roles for admin
        if($req->role_id){
            $user->roles()->detach($req->role_id);
        }
        //general user remove
        else{
            //manager remove for admin
            if($req->manager) $user->manager_id = null;            
            //general user remove
            else $user->status = 'x';
            $user->save();
        }

        return response()->json($user, 200);
    }

    public function restore($user) {
        $user = User::find($user);
        
        if (!$user) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $user->status = 'a';
        $user->save();

        return response()->json($user, 200);
    }


}
