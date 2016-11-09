<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Port extends Model {
  protected $table = 'ports';

  public function Concession() {
    return $this->hasMany('App\Model\Concession');
  }

  public function BuyerPort() {
    return $this->belongsTo('App\Model\BuyerPort');
  }

  public function SellerPort() {
      return $this->belongsTo('App\Model\SellerPort');
  }

  public function buyers() {
    return $this->belongsToMany(Buyer::class, 'buyer_port');
  }

  public function sellers() {
    return $this->belongsToMany(Seller::class, 'port_seller');
  }

}
