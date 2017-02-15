<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
  public function buy() {
    return $this->belongsTo(Currency::class, 'buy');
  }

  public function sell() {
    return $this->belongsTo(Currency::class, 'sell');
  }
}
