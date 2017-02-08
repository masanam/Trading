<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

// Document Model
// Created by Myrtyl
// 06/02/2017

class Document extends Model
{
    protected $table = 'documents';
    protected $fillable = [
      'id', 'template_id', 'shipment_id', 'user_id', 'title', 'remarks', 'url', 'older_version', 'newer_version', 'version', 'status'
    ];

    public function documentDetails() {
    	return $this->hasMany(DocumentDetail::class);
    }
    public function template() {
      return $this->belongsTo(Template::class, 'template_id');
    }
    public function shipment() {
      return $this->belongsTo(Shipment::class, 'shipment_id');
    }
    public function user() {
      return $this->belongsTo(User::class, 'user_id');
    }
}