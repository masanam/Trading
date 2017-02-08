<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// Document Details Model
// Created by Myrtyl
// 06/02/2017

class DocumentDetail extends Model
{
    protected $table = 'document_details';
    protected $fillable = [
      'id', 'document_id', 'field', 'content'
    ];

    public function document() {
      return $this->belongsTo(Document::class, 'document_id');
    }
}
