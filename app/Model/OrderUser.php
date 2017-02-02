<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderUser extends Model
{
    public $timestamps = false;
    protected $table = 'order_users';

    /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/
}
