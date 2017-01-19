<?php

namespace App\Http\Controllers;

use App\Model\Role;
use App\Model\Permission;
use Illuminate\Http\Request;

use Auth;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware(['jwt.auth', 'auth.admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $role = Role::get();

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
        $role = Role::find($id);

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
        $role = Role::find($id);
        $role->role = $req->role;
        $role->save();

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
