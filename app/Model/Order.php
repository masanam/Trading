<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Lead;
use App\Model\User;

class Order extends Model
{
  protected $table = 'orders';

  public function buys()
	{
      return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')
        ->withPivot('id', 'price', 'volume', 'payment_term', 'trading_term')->where('lead_type', 'b');
	}

  public function sells()
	{
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')
        ->withPivot('id', 'price', 'volume', 'payment_term', 'trading_term')->where('lead_type', 's');
	}
  
  public function earliestLaycan()
  {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')->orderBy('laycan_start')->select('laycan_start')->limit(1);
  }
  
  public function latestLaycan()
  {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')->orderBy('laycan_end', 'desc')->select('laycan_end')->limit(1);
  }
  
  public function buyPrice()
  {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')->where('lead_type', 'b')->select(DB::raw('SUM(order_details.volume*order_details.price)/SUM(order_details.volume) as price'));
  }
  
  public function sellPrice()
  {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')->where('lead_type', 's')->select(DB::raw('SUM(order_details.volume*order_details.price)/SUM(order_details.volume) as price'));
  }

  public function leads()
  {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')
      ->withPivot('id', 'price', 'volume', 'payment_term', 'trading_term');
  }

	public function approvals()
	{
		return $this->belongsToMany(User::class, 'order_approvals')->withPivot('status', 'updated_at');
	}

  public function trader() {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function users() {
    return $this->belongsToMany(User::class, 'order_users')->withPivot('role');
  }
}
