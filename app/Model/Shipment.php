<?php

namespace App\Model;

use App\Model\ShipmentLog;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{

  protected $table = 'shipments';
  protected $fillable = [
    'id','buyer_code', 'contract_id', 'supplier_id', 'customer_id', 'product_variant_id', 'surveyor_id', 'shipment_no', 'vessel_id', 'shipping_agent_id', 'fc', 'laycan_start_plan', 'laycan_start_actual', 'eta', 'loaded', 'etd', 'etc', 'laycan_end_plan', 'laycan_end_actual', 'volume', 'demurrage_rate', 'loading_rate', 'currency', 'price', 'bl_date', 'cargo_bl', 'adv_royalty', 'status', 'remark', 'stowage_plan', 'cargo_status', 'cargo_supply'
  ];

  //For Documents - By Myrtyl - 06/02/2017
    public function documents(){
      return $this->hasMany(Document::class);
    }

  //hasapu
    public function qualities(){
      return $this->hasMany(Quality::class)->where('status','a');
    }
  //------

    public function contracts() {
      return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function supplier() {
      return $this->belongsTo(Company::class, 'supplier_id');
    }

    public function customer() {
      return $this->belongsTo(Company::class, 'customer_id');
    }

    public function surveyors() {
      return $this->belongsTo(Company::class, 'surveyor_id');
    }

    public function products() {
      return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function vessel() {
      return $this->belongsTo(Vessel::class, 'vessel_id');
    }

    public function loader() {
      return $this->belongsTo(Loader::class, 'loader_id');
    }

    public function shipment_history() {
      return $this->hasMany(ShipmentHistory::class);
    }

    public function shipment_log() {
      return $this->hasMany(ShipmentLog::class);
    }

    public function latest_shipment_log() {
      return $this->hasOne(ShipmentLog::class)->latest();
    }

    public function latest_log(){
      return $this->hasMany(ShipmentLog::class)->orderBy('created_at')->first();
    }

    public function invoices() {
      return $this->hasOne(Invoice::class);
    }



}
