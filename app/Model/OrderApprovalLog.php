<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderApprovalLog extends Model
{
    protected $table = 'order_approval_logs';
    protected $fillable = [
    	'user_id',
    	'order_id',
    	'status'
    ];

    /*public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }*/
}
