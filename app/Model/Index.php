<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    protected $table = "index";

    public function getCreatedAtAttribute($value)
    {
        return date('d.m.Y H:i:s', strtotime($value));
    }
}
