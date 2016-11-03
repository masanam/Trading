<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Model\BuyOrder;
use App\Model\SellOrder;

class Order extends Model
{
    protected $table = 'orders';

    public function buys()
		{
      return $this->morphedByMany(BuyOrder::class, 'orderable', 'order_details');
		}

    public function sells()
		{
      return $this->morphedByMany(SellOrder::class, 'orderable', 'order_details');
		}

		public function approval()
		{
			return $this->hasMany(OrderApproval::class);
		}

    public function users() {
    	return $this->belongsTo(User::class);
    }
}
