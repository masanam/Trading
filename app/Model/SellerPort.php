<?php

namespace App\Model;

use App\Model\Seller;
use App\Model\Port;

use Illuminate\Database\Eloquent\Model;

class SellerPort extends Model
{
    protected $table = 'seller_port';

    public function Seller() {
        return $this->hasMany('App\Model\Seller', 'id', 'seller_id');
    }

    public function Port() {
        return $this->hasMany('App\Model\Port', 'id', 'port_id');
    }
}
