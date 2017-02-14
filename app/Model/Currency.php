<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
	public $incrementing = false;

  protected $primaryKey = 'id';

  public function exchange_rate() {
    return $this->hasMany(ExchangeRate::class);
  }

  public function buy() {
    return $this->hasMany(ExchangeRate::class, 'buy');
  }

  public function sell() {
    return $this->hasMany(ExchangeRate::class, 'sell');
  }
}
