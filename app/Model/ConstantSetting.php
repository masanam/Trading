<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConstantSetting extends Model
{		
    public $timestamps = false;
	
    protected $table = 'constants_setting';
    protected $fillable = [
        'constant_name', 'constant_value', 'status', 'used_in', 'date'
    ];
}
