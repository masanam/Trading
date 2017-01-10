<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderApproval extends Model
{
    protected $table = 'order_approvals';

    public function getCreatedAtAttribute($value)
    {
        return date('d.m.Y H:i:s', strtotime($value));
    }
}
