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
      return $this->morphedByMany(BuyOrder::class, 'detail_order', 'orderable_type', 'orderable_id');
		}

    public function sells()
		{
      return $this->morphedByMany(SellOrder::class, 'detail_order', 'orderable_type', 'orderable_id');
		}

		public function approval()
		{
			return $this->hasMany(OrderApproval::class);
		}

    public function users() {
    	return $this->belongsTo(User::class);
    }
}
