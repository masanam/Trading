<?php

namespace App\Http\Controllers;

use App\Model\User;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Password;

use App\Events\EditUserProfile;

use App\Http\Requests;

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
        
        if(!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }
        else if(!empty($user)){
            return response()->json([
                'message' => 'Your email is already registered. If you forgot your password, please send an enquiry to info@volantech.io'
            ], 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->image = $request->image;
        $user->title = $request->title;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);

        $user->employee_id = $request->employee_id;
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
        $user = User::with('directSubordinates','roles')->find($id);

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

        $user->name = $req->name;
        $user->image = $req->image;
        $user->title = $req->title;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->password = bcrypt($req->password);
        $user->employee_id = $req->employee_id;
        $user->manager_id = $req->manager_id;

        if($req->roles){
            // $user->roles()->detach();
            foreach ($req->roles as $r) {
                // if($user->roles[]->id != $r['id'])
                if (!$user->roles->contains($r['id']))
                    $user->roles()->attach($r['id']);
            }
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
