<?php

namespace App\Model;

use App\Model\Buyer;
use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    protected $table = 'ports';

    public function Concession() {
    	return $this->hasMany('App\Model\Concession');
    }

}
