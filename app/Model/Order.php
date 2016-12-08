<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
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
  
  public function earliest_laycans()
  {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')->earliest()->laycan_start;
  }
  
  public function latest_laycans()
  {
    return $this->belongsToMany(Lead::class, 'order_details', 'order_id', 'lead_id')->latest()->laycan_start;
  }

  public function orders()
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
