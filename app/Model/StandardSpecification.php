<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StandardSpecification extends Model
{	
    protected $table = 'standard_spec';
    protected $fillable = [
        'caloric_value', 'total_moisture', 'total_sulphur', 'ash'
    ];

}