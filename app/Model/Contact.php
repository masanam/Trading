<?php

namespace App\Model;

use App\Model\User;
use App\Model\Buyer;
use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    public function user() {
    	return $this->belongsTo('User');
    }

    public function buyer() {
    	return $this->belongsTo('Buyer');
    }

    public function seller() {
    	return $this->belongsTo('Seller');
    }
}
