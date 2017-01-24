<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Lead;
use App\Model\User;

// use Mpociot\Firebase\SyncsWithFirebase;

use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalRequest;

class Order extends Model
{
  // use SyncsWithFirebase;
  protected $table = 'orders';

  public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

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

  public function countLeads() {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')
      ->selectRaw('order_id, count(lead_id) as countLeads')->groupBy('order_id');
  }

  public function approvals() {
    return $this->belongsToMany(User::class, 'order_approvals')->withPivot('status', 'approval_token', 'updated_at');
  }

	public function approvalLogs() {
		return $this->belongsToMany(User::class, 'order_approval_logs')->withPivot('status', 'updated_at');
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

  public function requestApproval($user){
    // You can only add approval record from a user
    // that HAS NOT YET been here before
    // if($this->getApproverByUserId($user->id)) return false;

    /*
     * UPDATE DATA NOW!
     */

    // Add new approval request
    $approval_properties = [
      'status' => 'p',
      'approval_token' => bcrypt(date('Y-m-d H:i:s') . $user->name)
    ];
    $this->approvals()->sync([$user->id => $approval_properties], false);

    // add new associated user in the request
    $this->users()->sync([$user->id => [ 'role' => 'approver' ]], false);


    /*
     * FIND ALL NECESSARY ELEMENTS TO SEND EMAILS
     */

    // get the earliest laycan and latest one
    $this->earliestLaycan();
    $this->latestLaycan();

    // find all averages of the order details.
    $this->averageSell();
    $this->averageBuy();

    // get latest GC NEWC price
    $index = IndexPrice::orderBy('date', 'DESC')->where('index_id', 10)->first();

    $mail = new ApprovalRequest($this, $approval_properties['approval_token'], $index->price);
    Mail::to($user->email)->send($mail);


    /*
     * Interim Logic
     *
     * Approval statuses:
     * [p] --> pending ;    [m] --> pending, but acting
     * [a] --> approved ;   [y] --> automatically approved
     * [r] --> rejected ;   [n] --> automatically rejected
     */

    // Interim roles is non-descendable
    // Only applied to 1 level directly below
    $interims = $user->interims;

    if($interims) {
      // add approval, association and email to all associated Users!
      foreach($interims as $interim){
        // If current user already inside approval list, don't add
        if(!$this->approvals->contains($interim->id)){
          $approval_properties = [
            'status' => 'm',
            'approval_token' => bcrypt(date('Y-m-d H:i:s') . $interim->name)
          ];

          // add the user to the approval list
          $this->approvals()->attach($interim->id, $approval_properties);
          // and associate him/her to the order
          $this->users()->sync([$user->id => [ 'role' => 'approver' ]], false);

          // Send the email now
          $mail = new ApprovalRequest($this, $approval_properties['approval_token'], $index->price);
          Mail::to($interim->email)->send($mail);
        }
      }
      return true;
    }
    else return false;
  }

  public function resetApproval(){
    // delete all approval, then
    // add new approval starting from second level manager
    $this->approvals()->detach();
    $this->requestApproval(User::find($this->trader->manager_id));
  }

  public function leadToPartial(){
    $buy_ids = $this->buys()->pluck('leads.id');
    Lead::whereIn('id', $buy_ids)->update(['order_status' => 'p']);
    if(isset($buy_ids)) {
      foreach ($buy_ids as $id) {
        $this->buys()->detach($id);
      }
    }
    $sell_ids = $this->sells()->pluck('leads.id');
    Lead::whereIn('id', $sell_ids)->update(['order_status' => 'p']);
    if(isset($sell_ids)) {
      foreach ($sell_ids as $id) {
        $this->sells()->detach($id);
      }
    }
  }
}
