<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\Port;

use Illuminate\Database\Eloquent\Model;

class BuyerPort extends Model
{
    public $timestamps = false;
    protected $table = 'buyer_port';

    public function Buyer() {
        return $this->hasMany('App\Model\Buyer', 'id', 'buyer_id');
    }

    public function Port() {
        return $this->hasOne('App\Model\Port', 'id', 'port_id');
    }
}
