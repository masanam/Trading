<?php

namespace App\Http\Controllers;

use App\Model\Role;
use App\Model\Permission;
use Illuminate\Http\Request;

use Auth;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware(['jwt.auth', 'auth.admin'], ['except' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $role = Role::with('privileges')->get();

        // kamal used at order approval managements
        if($req->role_id) $role = Role::with('users')->find($req->role_id);

        return response()->json($role, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        if(!$req) {
            return response()->json([
              'message' => 'Bad Request'
            ], 400);
        }

        // if create role
        if($req->role){
            $role = new Role();
            $role->role = $req->role;
        }
        // if create permission
        // else if($req->permission){
        //     $role = new Permission();
        //     $role->permission = $req->permission;
        // }

        $role->save();
        return response()->json($role, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::with('privileges')->find($id);

        return response()->json($role, 200);
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
        $role = Role::with('privileges')->find($id);
        $privileges = [];
        foreach ($req->privileges as $p) {
            $privileges[] = $p['id'];
        }
        // $privileges = pluck($req->privileges->id);
        if($privileges) $role->privileges()->sync($privileges);
        else $role->privileges()->detach();

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
        //
    }
}
