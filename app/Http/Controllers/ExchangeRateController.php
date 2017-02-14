<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\ExchangeRate;

use DB;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $exchange_rate = ExchangeRate::with('buy', 'sell')->where('in_use', true)->get();

      return response()->json($exchange_rate, 200);
    }

    public function findHistory($buy, $sell) {
      $value = []; $created_at = [];
      $exchange_rates = ExchangeRate::where([['buy', $buy], ['sell', $sell]])->get();
      foreach($exchange_rates as $e) {
        $value[] = $e->value; $created_at[] = $e->created_at->format('d M Y - H:i:s');
      }

      return response()->json(['value' => $value, 'created_at' => $created_at], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      DB::table('exchange_rates')->where([['buy', 'LIKE', $request->buy], ['sell', 'LIKE', $request->sell]])->update(['in_use' => 0]);
      $exchange_rate = new ExchangeRate();
      $exchange_rate->buy = $request->buy;
      $exchange_rate->sell = $request->sell;
      $exchange_rate->value = $request->value;
      $exchange_rate->in_use = true;

      $exchange_rate->save();
      
      return response()->json($exchange_rate, 200);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
