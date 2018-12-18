<?php

namespace App\Http\Controllers;

use App\Model\ConstantSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ConstantSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $constants_setting = ConstantSetting::where('status', 'a')->orderBy('date', 'DESC');  
        
        $constants_setting = $constants_setting->get();
        return response()->json($constants_setting, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConstantSetting  $constantSetting
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $constant_setting = ConstantSetting::find($id);

        if(!$constant_setting) return response()->json([ 'message' => 'Not Found' ], 404);

        return response()->json($constant_setting, 200);
    }

    public function findHistory(Request $req) {
      $constant_value = []; 
      $last_updated = [];

      $constant_history = ConstantSetting::where([['constant_name', '=', $req->name]])->orderBy('date','DESC')->get();
      
      foreach($constant_history as $c) {
        $constant_value[] = $c->constant_value; $last_updated[] = $c->last_updated;
      }

      return response()->json($constant_history, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConstantSetting  $constantSetting
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
      DB::table('constants_setting')->where([['constant_name', '=', $request->constant_name], ['used_in', '=', $request->used_in]])->update(['status' => 'h']);

      $constant_setting = new ConstantSetting();
      $constant_setting->constant_name = $request->constant_name;
      $constant_setting->constant_value = $request->constant_value;
      $constant_setting->used_in = $request->used_in;
      $constant_setting->status = 'a';
      $constant_setting->date = date('Y-m-d', strtotime($request->date));
      $constant_setting->last_updated = Date('Y-m-d H:i:s');


      $constant_setting->save();

      return response()->json($constant_setting, 200);
    }
    
}
