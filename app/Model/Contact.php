<?php

namespace App\Model;

use App\Model\User;
use App\Model\Buyer;
use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    public function User() {
    	return $this->belongsTo('User');
    }

    public function Buyer() {
    	return $this->belongsTo('Buyer');
    }

    public function Seller() {
    	return $this->belongsTo('Seller');
    }
}
