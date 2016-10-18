<?php

namespace App;

use App\Model\Buyer;
use App\Model\Port;

use Illuminate\Database\Eloquent\Model;

class BuyerPort extends Model
{
    protected $table = 'buyer_port';

    public function Buyer() {
        return $this->hasMany('App\Model\Buyer');
    }

    public function Port() {
        return $this->hasMany('App\Model\Port');
    }
}
