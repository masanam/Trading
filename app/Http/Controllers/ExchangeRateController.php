<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\ExchangeRate;
use App\Model\Currency;

use Ixudra\Curl\Facades\Curl;

use DB;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $exchange_rate = ExchangeRate::where('in_use', true);

      if($request->related) return $this->findRelatedExchangeRate($request->related);

      if($request->latest == true){
        if($request->buy)
          if($request->sell)
            return $this->findOne($request->buy, $request->sell);
      }
      else return $this->findHistory($request->buy, $request->sell);


      if(!($request->q_buy||$request->q_sell)) return response()->json('buy or sell query not found', 400);
      // if($request->q) {
        // $q = json_decode($request->q);
        // dd(strtoupper($q->sell));
        if($request->q_buy) $exchange_rate = $exchange_rate->where('buy', 'LIKE', $request->q_buy.'%');
        if($request->q_sell) $exchange_rate = $exchange_rate->where('sell', 'LIKE', $request->q_sell.'%');
      // }
      // if($request->qbuy) $exchange_rate = $exchange_rate->where('buy', '%'.strtoupper($request->qbuy).'%');
      // if($request->qsell) $exchange_rate = $exchange_rate->where('sell', '%'.strtoupper($request->qsell).'%');

      $exchange_rate = $exchange_rate->get();

      return response()->json($exchange_rate, 200);
    }

    public function findHistory($buy, $sell) {
      $value = []; $created_at = [];
      $exchange_rates = ExchangeRate::where([['buy', $buy], ['sell', $sell]])->get();
      foreach($exchange_rates as $e) {
        $value[] = $e->value; $created_at[] = $e->created_at->format('Y M d');
      }

      return response()->json(['value' => $value, 'created_at' => $created_at], 200);
    }


    public function findOne($buy, $sell) {

      $currency = ExchangeRate::where('in_use', 1)->where('buy', $buy)->where('sell', $sell)->first();

      return response()->json($currency, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //take latest exchange rate
    // public function updateLatestExchangeRate($currency) {
    //   DB::table('exchange_rates')->update(['in_use' => 0]);
    //   $currency = Currency::pluck('id');
    //   foreach($currency as $c) {
    //     $response = json_decode(Curl::to('api.fixer.io/latest?base='.$c)->get());
    //     if($response) {
    //       foreach ($response->rates as $key => $value) {
    //         $exchange_rate = new ExchangeRate();
    //         $exchange_rate->buy = $c;
    //         $exchange_rate->sell = $key;
    //         $exchange_rate->value = $value;
    //         $exchange_rate->in_use = true;

    //         $exchange_rate->save();
    //       }
    //     }
    //     else return response()->json(['message'=>'Cannot update with the current price, please check your internet connection'], 500);
    //   }
    // }

    public function saveInBulk($req) {
      if(count($req->data)) {
        DB::table('exchange_rates')->where('buy', $req->data[0]['buy'])->update(['in_use' => 0]);
        foreach ($req->data as $value) {
          $exchange_rate = new ExchangeRate();
          $exchange_rate->buy = $value['buy'];
          $exchange_rate->sell = $value['sell'];
          $exchange_rate->value = $value['value'];
          $exchange_rate->in_use = true;

          $exchange_rate->save();
        }

        return response()->json(['message'=>'Exchange rate update for '. $req->data[0]['buy'] .' as buy is done'], 200);
      }
    }

    public function findRelatedExchangeRate($currency) {
      $exchange_rate = ExchangeRate::where('in_use', true)->where(function($query) use($currency){
        $query->orWhere('buy', $currency)->orWhere('sell', $currency);
      })->orderByRaw('buy = ? desc',[$currency])->get();

      return response()->json($exchange_rate, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if($request->bulk == true) return $this->saveInBulk($request);

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
    public function update(Request $request)
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
