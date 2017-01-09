<?php

namespace App\Http\Controllers;

use App\Model\Role;
use Illuminate\Http\Request;

use Auth;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware(['jwt.auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        dd(Auth::user()->roles());

        return array_search('admin', $user->roles());
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

      $role = new Role();
      $role->role_name = $req->role_name;
      $role->access = json_encode($req->access);

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
