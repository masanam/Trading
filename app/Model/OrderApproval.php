<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderApproval extends Model
{
    protected $table = 'order_approvals';

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }
}
