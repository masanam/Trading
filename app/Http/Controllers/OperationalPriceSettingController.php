<?php

namespace App\Http\Controllers;

use App\Model\OperationalPriceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationalPriceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $operational_prices = OperationalPriceSetting::where('status', 'a')->orderBy('date', 'DESC');

        if($req->province) {
          $operational_prices = $operational_prices->where('province',$req->province);
        }

        $operational_prices = $operational_prices->get();
        return response()->json($operational_prices, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConstantSetting  $constantSetting
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $operational_price = OperationalPriceSetting::find($id);

        if(!$operational_price) return response()->json([ 'message' => 'Not Found' ], 404);

        return response()->json($operational_price, 200);

    }

    public function findHistory(Request $req) {
      $price = [];
      $last_updated = [];

      $price_history = OperationalPriceSetting::where([['name', '=', $req->name], ['province', '=', $req->province]])->orderBy('date','DESC')->get();

      foreach($price_history as $c) {
        $price[] = $c->price; $last_updated[] = $c->last_updated;
      }

      return response()->json($price_history, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConstantSetting  $constantSetting
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConstantSetting  $constantSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {

    }

    public function updateInBulk(Request $req)
    {
      foreach($req->selected as $id){
        $operational_price = OperationalPriceSetting::find($id['id']);
        DB::table('operational_price')->where([['id', '=', $id['id']]])->update(['status' => 'h']);
        $new_price = new OperationalPriceSetting();
        $new_price->name = $operational_price->name;
        $new_price->province = $operational_price->province;
        $new_price->price = $req->price;
        $new_price->status = 'a';
        $new_price->date = Date('Y-m-d');
        $new_price->last_updated = Date('Y-m-d H:i:s');
        $new_price->save();
        }
        
      return response()->json($operational_price, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConstantSetting  $constantSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
