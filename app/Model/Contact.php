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

    protected $fillable = ['name', 'phone', 'email'];

    /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/

    public function user() {
    	return $this->belongsTo('User');
    }

    public function company() {
    	return $this->belongsTo('Company');
    }
}
