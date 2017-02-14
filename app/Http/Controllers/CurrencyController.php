<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Currency;
use App\Model\ExchangeRate;

use DB;

class CurrencyController extends Controller
{
    public function __construct() {
      $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $currencies = Currency::with('buy', 'sell')->get();
        $exchange_rate = ExchangeRate::with('buy', 'sell')->where('in_use', true)->get();
        // $exchange_rate = DB::raw('SELECT id,created_at FROM exchange_rates a WHERE created_at=(SELECT max(created_at) FROM exchange_rates b WHERE a.id=b.id');

        return response()->json($exchange_rate, 200);
        // return response()->json($currencies, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $currency = new Currency();
      $currency->id = $request->id;
      $currency->value = $request->value;

      $currency->save();

      return response()->json($currency, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $currency = Currency::find($id);

      return response()->json($currency, 200);
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
      $currency = Currency::find($id);

      $currency->id = $request->id;
      $currency->value = $request->value;

      $currency->save();

      return response()->json($currency, 200);
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
