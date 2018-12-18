<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Equation extends Model
{
    public $timestamps = false;
	
    protected $table = 'equations';
    protected $fillable = [
        'equation_name', 'equation_desc', 'equation'
    ];

}
