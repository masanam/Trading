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
}
