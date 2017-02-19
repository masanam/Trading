<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Company;

class OrderAdditionalCost extends Model
{
    protected $table = 'order_additional_costs';

	public function order() {
		return $this->belongsTo(Order::class, 'order_id');
	}
	public function company() {
		return $this->belongsTo(Company::class, 'company_id');
	}
}
