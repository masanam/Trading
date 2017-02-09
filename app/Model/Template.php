<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// Template Model
// Created by Myrtyl
// 06/02/2017

class Template extends Model
{
    protected $table = 'templates';
    protected $fillable = [
      'id', 'template_name', 'desc', 'category', 'sequence', 'fields', 'status'
    ];

    public function documents() {
    	return $this->hasMany(Document::class);
    }
}
