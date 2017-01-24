<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    protected $table = "index";

    /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/
}
