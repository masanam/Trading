<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Lead;
use App\Model\User;

class Order extends Model
{
  protected $table = 'orders';

  /*
   * Relations 
   * 
   */
  public function buys() {
      return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')
        ->withPivot('id', 'price', 'volume', 'payment_term', 'trading_term')->where('lead_type', 'b');
	}

  public function sells() {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')
        ->withPivot('id', 'price', 'volume', 'payment_term', 'trading_term')->where('lead_type', 's');
	}
  
  public function leads()
  {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')
      ->withPivot('id', 'price', 'volume', 'payment_term', 'trading_term');
  }

	public function approvals() {
		return $this->belongsToMany(User::class, 'order_approvals')->withPivot('status', 'updated_at');
	}

  public function trader() {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function users() {
    return $this->belongsToMany(User::class, 'order_users')->withPivot('role');
  }



  // Model Functions
  public function averageSell() {
    $price = $volume = 0;

    foreach($this->sells as &$sell){
      $price += $sell->pivot->price * $sell->pivot->volume;
      $volume += $sell->pivot->volume;
    }

    $this->average_sell_price = $price/$volume;
  }

  public function averageBuy() {
    $price = $volume = 0;

    foreach($this->buys as &$buy){
      $price += $buy->pivot->price * $buy->pivot->volume;
      $volume += $buy->pivot->volume;
    }

    $this->average_buy_price = $price/$volume;
  }

  public function earliestLaycan(){
    $this->laycan_start = min($this->buys->min('laycan_start'), $this->sells->min('laycan_start'));
  }

  public function latestLaycan(){
    $this->laycan_end = max($this->buys->max('laycan_end'), $this->sells->max('laycan_end'));
  }

  public function getNegotiations(){
    foreach($this->sells as &$sell) $sell->pivot->negotiations = OrderNegotiation::where('order_detail_id', '=', $sell->pivot->id)->get();
    foreach($this->buys as &$buy) $buy->pivot->negotiations = OrderNegotiation::where('order_detail_id', '=', $buy->pivot->id)->get();
  }
}
