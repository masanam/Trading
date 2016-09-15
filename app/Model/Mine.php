<?php

namespace App\Model;

use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Mine extends Model
{
    protected $table = 'mines';

    public function seller() {
    	return $this->belongsTo('Seller');
    }
}
