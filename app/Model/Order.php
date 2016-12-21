<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Lead;
use App\Model\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalRequest;

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
		return $this->belongsToMany(User::class, 'order_approvals')->withPivot('status', 'approval_token', 'updated_at');
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


  // Model Functions
  public function averageSell() {
    $price = $volume = 0;

    foreach($this->sells as &$sell){
      $price += $sell->pivot->price * $sell->pivot->volume;
      $volume += $sell->pivot->volume;
    }

    if($volume) $this->average_sell_price = $price/$volume;
    else $this->average_sell_price = 0;
  }

  public function averageBuy() {
    $price = $volume = 0;

    foreach($this->buys as &$buy){
      $price += $buy->pivot->price * $buy->pivot->volume;
      $volume += $buy->pivot->volume;
    }

    if($volume) $this->average_buy_price = $price/$volume;
    else $this->average_buy_price = 0;
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

  public function getApproverByToken($approval_token){
    foreach($this->approvals as $a)
      if($a->pivot->approval_token == $approval_token) return $a;
  }

  public function getApproverByUserId($user_id){
    foreach($this->approvals as $a){
      if($a->id == $user_id) return $a;
    }
  }

  public function requestApproval($user){
    // You can only add approval record from a user
    // that HAS NOT YET been here before
    // if($this->getApproverByUserId($user->id)) return false;

    // get the earliest laycan and latest one
    $this->earliestLaycan();
    $this->latestLaycan();

    // find all averages of the order details.
    $this->averageSell(); 
    $this->averageBuy();

    // get latest GC NEWC price
    $index = IndexPrice::orderBy('date', 'DESC')->where('index_id', 10)->first();

    // Add new approval request
    $approval_properties = [
      'status' => 'p',
      'approval_token' => bcrypt(date('Y-m-d H:i:s') . $user->name)
    ];
    $this->approvals()->sync([$user->id => $approval_properties], false);

    $mail = new ApprovalRequest($this, $approval_properties['approval_token'], $index->price);
    Mail::to($user->email)->send($mail);

    // add new associated user in the request
    $this->users()->sync([$user->id => [ 'role' => 'approver' ]], false);

    return true;
  }
}
