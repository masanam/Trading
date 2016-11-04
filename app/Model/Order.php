<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\BuyOrder;
use App\Model\SellOrder;
use App\Model\User;

class Order extends Model
{
    protected $table = 'orders';

    public function buys()
		{
      return $this->morphedByMany(BuyOrder::class, 'orderable', 'order_details')->withPivot('id', 'price', 'volume');;
		}

    public function sells()
		{
      return $this->morphedByMany(SellOrder::class, 'orderable', 'order_details')->withPivot('id', 'price', 'volume');;
		}

		public function approval()
		{
			return $this->belongsToMany(User::class, 'order_approvals')->withPivot('status', 'updated_at');
		}

    public function users() {
    	return $this->belongsTo(User::class);
    }
}
