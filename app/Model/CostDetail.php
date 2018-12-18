<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CostDetail extends Model
{    
	
    protected $table = 'cost_details';
    protected $fillable = [
        'section_id', 'header_id', 'user_id', 'desc', 'value', 'quantity' ];

    public function costSection() {
        return $this->belongsTo(CostSection::class,'section_id');
    }

    public function costHeader() {
        return $this->belongsTo(CostHeader::class,'header_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
