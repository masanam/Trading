<?php

namespace App\Model;

use Laravel\Scout\Searchable;

use App\Model\User;
use App\Model\Buyer;
use App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use Searchable;

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
