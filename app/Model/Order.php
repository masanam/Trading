<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Lead;
use App\Model\User;

// use Mpociot\Firebase\SyncsWithFirebase;

class Order extends Model
{
  // use SyncsWithFirebase;
  protected $table = 'orders';

  /*
   * Relations
   *
   */
  public function buys() {
      return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')
        ->withPivot('id', 'price', 'base_currency_id', 'base_price', 'exchange_rate', 'deal_currency_id', 'deal_price', 'volume', 'payment_term', 'trading_term')->where('lead_type', 'b');
	}

  public function sells() {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')
        ->withPivot('id', 'price', 'base_currency_id', 'base_price', 'exchange_rate', 'deal_currency_id', 'deal_price', 'volume', 'payment_term', 'trading_term')->where('lead_type', 's');
	}

  public function leads()
  {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')
      ->withPivot('id', 'price', 'base_currency_id', 'base_price', 'exchange_rate', 'volume', 'payment_term', 'trading_term');
  }

  public function countLeads() {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')
      ->selectRaw('order_id, count(lead_id) as countLeads')->groupBy('order_id');
  }

  public function approvals() {
    return $this->belongsToMany(User::class, 'order_approvals')->withPivot('status', 'approval_token', 'reason', 'updated_at');
  }

	public function approvalLogs() {
		return $this->belongsToMany(User::class, 'order_approval_logs')->withPivot('status','reason', 'updated_at');
	}

  public function trader() {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function users() {
    return $this->belongsToMany(User::class, 'order_users')->withPivot('role');
  }

  public function companies() {
    return $this->belongsToMany(Company::class, 'order_additional_costs', 'order_id', 'company_id')->withPivot('label', 'cost');
  }

  public function contracts() {
    return $this->hasOne(Contract::class);
  }

  public function additional_cost() {
    return $this->hasMany(OrderAdditionalCost::class);
  }

  // Model Functions
  public function averageSell() {
    $price = $volume = 0;

    foreach($this->sells as &$sell){
      $price += $sell->pivot->base_price * $sell->pivot->volume;
      $volume += $sell->pivot->volume;
    }

    if($volume) $this->average_sell_price = $price/$volume;
    else $this->average_sell_price = 0;
  }

  public function averageBuy() {
    $price = $volume = 0;

    foreach($this->buys as &$buy){
      $price += $buy->pivot->base_price * $buy->pivot->volume;
      $volume += $buy->pivot->volume;
    }

    if($volume) $this->average_buy_price = $price/$volume;
    else $this->average_buy_price = 0;
  }

  public function totalPrice() {
    $this->total_buy_price = $this->total_sell_price = $this->total_buy_volume = $this->total_sell_volume = $this->total_additional_costs = 0;

    foreach($this->buys as &$buy){
      $this->total_buy_price += $buy->pivot->base_price * $buy->pivot->volume;
      $this->total_buy_volume += $buy->pivot->volume;
    }
    if($this->total_buy_volume) $this->total_buy_price = $this->total_buy_price / $this->total_buy_volume;

    foreach($this->sells as &$sell){
      $this->total_sell_price += $sell->pivot->base_price * $sell->pivot->volume;
      $this->total_sell_volume += $sell->pivot->volume;
    }

    if($this->total_sell_volume) $this->total_sell_price = $this->total_sell_price / $this->total_sell_volume;

    foreach($this->additional_cost as &$add){
      if(!count($this->buys)) $this->total_sell_price -= $add->cost;
      if(!count($this->sells)) $this->total_buy_price += $add->cost;
      $this->total_additional_costs += $add->cost;
    }
  }

  public function earliestLaycan(){
    if(!count($this->buys)) $this->laycan_start = $this->sells->min('laycan_start');
    else if(!count($this->sells)) $this->laycan_start = $this->buys->min('laycan_start');
    else $this->laycan_start = min($this->buys->min('laycan_start'), $this->sells->min('laycan_start'));
  }

  public function latestLaycan(){
    $this->laycan_end = max($this->buys->max('laycan_end'), $this->sells->max('laycan_end'));
  }

  public function getNegotiations(){
    foreach($this->sells as &$sell) $sell->pivot->negotiations = OrderNegotiation::where('order_detail_id', '=', $sell->pivot->id)->get();
    foreach($this->buys as &$buy) $buy->pivot->negotiations = OrderNegotiation::where('order_detail_id', '=', $buy->pivot->id)->get();
  }

  public function leadToPartial(){
    $buy_ids = $this->buys()->pluck('leads.id');
    Lead::whereIn('id', $buy_ids)->update(['order_status' => 'p']);

    $sell_ids = $this->sells()->pluck('leads.id');
    Lead::whereIn('id', $sell_ids)->update(['order_status' => 'p']);
  }

  public function addAdditionalCosts($additional) {
    if(count($additional) > 0) {
      $this->companies()->detach();

      foreach($additional as $add) {
        $this->companies()->attach([$add['company']['id'] => [
          'cost' => $add['cost'],
          'label' => $add['label']
        ]]);
      }
    }
  }

}
