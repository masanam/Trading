<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\ExchangeRate;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
