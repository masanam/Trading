<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\Contact;
use App\Model\Concession;
use App\Model\Factory;
use App\Model\Product;
use App\Model\Port;
use App\Model\Area;
use App\Model\QualityMetric;
use App\Model\Quality;
use App\Model\Shipment;
use App\Model\Contract;
use App\Model\QualityDetail;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Events\InputEditCoalpedia;

class QualityDetailController extends Controller
{
  public function __construct() {
    $this->middleware('jwt.auth');
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Request $req)
  {    
    $quality_metrics = QualityMetric::all();   
    if($req->shipment_id) {
        $quality['b'] = Quality::with(['qualityDetail' => function($query){
          $query->orderBy('quality_metrics_id','asc');
        }],'qualityDetail.qualityMetric')->where([['shipment_id', $req->shipment_id],['type','b']]);        
        $quality['b'] = $quality['b']->first();

        $quality['a'] = Quality::with(['qualityDetail' => function($query){
          $query->orderBy('quality_metrics_id','asc');
        }],'qualityDetail.qualityMetric')->where([['shipment_id', $req->shipment_id],['type','a']]);        
        $quality['a'] = $quality['a']->first();
    }
    if($req->contract_id) {
      $quality['t'] = Quality::with(['qualityDetail' => function($query){
        $query->orderBy('quality_metrics_id','asc');
      }],'qualityDetail.qualityMetric')->where([['contract_id', $req->contract_id],['type','t']]);
      $quality['t'] = $quality['t']->first();

      $quality['r'] = Quality::with(['qualityDetail' => function($query){
        $query->orderBy('quality_metrics_id','asc');
      }],'qualityDetail.qualityMetric')->where([['contract_id', $req->contract_id],['type','r']]);
      $quality['r'] = $quality['r']->first();

    }    
    // return response()->json($quality);
    $metric_array = [];
    // $metric_array->t = [];
    // $metric_array->r = [];
    // return($metric_array);
    $j=0;
    $k=0;
    $l=0;
    $m=0;
    for($i=0; $i<count($quality_metrics);$i++){
      $metric = new Quality;
      if(isset($quality['t']->qualityDetail[$j])){
        if($quality['t']->qualityDetail[$j]->quality_metrics_id==$quality_metrics[$i]->id){ 
          $metric->t_quality_id = $quality['t']->id;         
          $metric->t_detail_id = $quality['t']->qualityDetail[$j]->id;
          $metric->metric_id = $quality['t']->qualityDetail[$j]->qualityMetric->id;
          $metric->quality = $quality['t']->qualityDetail[$j]->qualityMetric->quality;
          $metric->metric = $quality['t']->qualityDetail[$j]->qualityMetric->metric;
          $metric->t_value = $quality['t']->qualityDetail[$j]->value;            
          $j++;
        }else{            
          $metric->t_quality_id = $quality['t']->id;
          $metric->metric_id = $quality_metrics[$i]->id;
          $metric->quality = $quality_metrics[$i]->quality;
          $metric->metric = $quality_metrics[$i]->metric;
          $metric->t_value = 0;
        }
      }else{
        if(isset($quality['t'])) $metric->t_quality_id = $quality['t']->id;                  
        $metric->metric_id = $quality_metrics[$i]->id;
        $metric->quality = $quality_metrics[$i]->quality;
        $metric->metric = $quality_metrics[$i]->metric;
        $metric->t_value = 0;          
      }
        
      if(isset($quality['r']->qualityDetail[$k])){
        if($quality['r']->qualityDetail[$k]->quality_metrics_id==$quality_metrics[$i]->id){ 
          $metric->r_quality_id = $quality['r']->id;         
          $metric->r_detail_id = $quality['r']->qualityDetail[$k]->id;
          $metric->metric_id = $quality['r']->qualityDetail[$k]->qualityMetric->id;
          $metric->quality = $quality['r']->qualityDetail[$k]->qualityMetric->quality;
          $metric->metric = $quality['r']->qualityDetail[$k]->qualityMetric->metric;
          $metric->r_value = $quality['r']->qualityDetail[$k]->value;            
          $k++;
        }else{            
          $metric->r_quality_id = $quality['r']->id;
          $metric->metric_id = $quality_metrics[$i]->id;
          $metric->quality = $quality_metrics[$i]->quality;
          $metric->metric = $quality_metrics[$i]->metric;
          $metric->r_value = 0;
        }
      }else{
        if(isset($quality['r'])) $metric->r_quality_id = $quality['r']->id;                  
        $metric->metric_id = $quality_metrics[$i]->id;
        $metric->quality = $quality_metrics[$i]->quality;
        $metric->metric = $quality_metrics[$i]->metric;
        $metric->r_value = 0;          
      }

      if($req->type=='pre' || $req->type=='post' ){
        if(isset($quality['b']->qualityDetail[$l])){
          if($quality['b']->qualityDetail[$l]->quality_metrics_id==$quality_metrics[$i]->id){ 
            $metric->b_quality_id = $quality['b']->id;         
            $metric->b_detail_id = $quality['b']->qualityDetail[$l]->id;
            $metric->metric_id = $quality['b']->qualityDetail[$l]->qualityMetric->id;
            $metric->quality = $quality['b']->qualityDetail[$l]->qualityMetric->quality;
            $metric->metric = $quality['b']->qualityDetail[$l]->qualityMetric->metric;
            $metric->b_value = $quality['b']->qualityDetail[$l]->value;            
            $l++;
          }else{            
            $metric->b_quality_id = $quality['b']->id;
            $metric->metric_id = $quality_metrics[$i]->id;
            $metric->quality = $quality_metrics[$i]->quality;
            $metric->metric = $quality_metrics[$i]->metric;
            $metric->b_value = 0;
          }
        }else{
          if(isset($quality['b'])) $metric->b_quality_id = $quality['b']->id;                  
          $metric->metric_id = $quality_metrics[$i]->id;
          $metric->quality = $quality_metrics[$i]->quality;
          $metric->metric = $quality_metrics[$i]->metric;
          $metric->b_value = 0;          
        }
      }

      if($req->type=='post'){
        if(isset($quality['a']->qualityDetail[$m])){
          if($quality['a']->qualityDetail[$m]->quality_metrics_id==$quality_metrics[$i]->id){ 
            $metric->a_quality_id = $quality['a']->id;         
            $metric->a_detail_id = $quality['a']->qualityDetail[$m]->id;
            $metric->metric_id = $quality['a']->qualityDetail[$m]->qualityMetric->id;
            $metric->quality = $quality['a']->qualityDetail[$m]->qualityMetric->quality;
            $metric->metric = $quality['a']->qualityDetail[$m]->qualityMetric->metric;
            $metric->a_value = $quality['a']->qualityDetail[$m]->value;            
            $m++;
          }else{            
            $metric->a_quality_id = $quality['a']->id;
            $metric->metric_id = $quality_metrics[$i]->id;
            $metric->quality = $quality_metrics[$i]->quality;
            $metric->metric = $quality_metrics[$i]->metric;
            $metric->a_value = 0;
          }
        }else{
          if(isset($quality['a'])) $metric->a_quality_id = $quality['a']->id;                  
          $metric->metric_id = $quality_metrics[$i]->id;
          $metric->quality = $quality_metrics[$i]->quality;
          $metric->metric = $quality_metrics[$i]->metric;
          $metric->a_value = 0;          
        }
      }

      array_push($metric_array, $metric);
      // $r[] = $metric;

    }

      // $metric_array->t = $t;
      // $metric_array->r = $r;

         
      return response()->json($metric_array, 200);      
      
  }

  public function store(Request $req){
    // return response()->json($req->metric);

    if($req->type=='pre'){
      foreach ($req->metric as $key=> $value) {    
        if(isset($value['b_quality_id'])){
          if(isset($value['b_detail_id'])){
            $metric = QualityDetail::find($value['b_detail_id']);
            $metric->value = $value['b_value'];
            $metric->save();
          }else if($value['b_value']!=0){
            $metric = new QualityDetail();
            $metric->quality_id = $value['b_quality_id'];
            $metric->value = $value['b_value'];
            $metric->quality_metrics_id = $value['metric_id'] ;
            $metric->save();
          }        
        }else{        
          if($key==0){
            $quality = new Quality();
            $quality->shipment_id = $req->shipment_id;
            $quality->status = 'a';
            $quality->type = 'b';
            $quality->save();
            $x = Quality::where('type','b')->orderBy('created_at', 'desc')->first();
            $b_quality_id = $x->id;        
          }

          if($value['b_value']!=0){
            $metric = new QualityDetail();
            $metric->quality_id = $b_quality_id;
            $metric->value = $value['b_value'];
            $metric->quality_metrics_id = $value['metric_id'] ;
            $metric->save();
          }   
        }
      }

    }else if($req->type=='post'){
      foreach ($req->metric as $key=> $value) {    
        if(isset($value['a_quality_id'])){
          if(isset($value['a_detail_id'])){
            $metric = QualityDetail::find($value['a_detail_id']);
            $metric->value = $value['a_value'];
            $metric->save();
          }else if($value['a_value']!=0){
            $metric = new QualityDetail();
            $metric->quality_id = $value['a_quality_id'];
            $metric->value = $value['a_value'];
            $metric->quality_metrics_id = $value['metric_id'] ;
            $metric->save();
          }        
        }else{        
          if($key==0){
            $quality = new Quality();
            $quality->shipment_id = $req->shipment_id;
            $quality->status = 'a';
            $quality->type = 'a';
            $quality->save();
            $x = Quality::where('type','a')->orderBy('created_at', 'desc')->first();
            $a_quality_id = $x->id;        
          }

          if($value['a_value']!=0){
            $metric = new QualityDetail();
            $metric->quality_id = $a_quality_id;
            $metric->value = $value['a_value'];
            $metric->quality_metrics_id = $value['metric_id'] ;
            $metric->save();
          }   
        }
      }

    }else{

      foreach ($req->metric as $key=> $value) {    
        if(isset($value['t_quality_id'])){
          if(isset($value['t_detail_id'])){
            $metric = QualityDetail::find($value['t_detail_id']);
            $metric->value = $value['t_value'];
            $metric->save();
          }else if($value['t_value']!=0){
            $metric = new QualityDetail();
            $metric->quality_id = $value['t_quality_id'];
            $metric->value = $value['t_value'];
            $metric->quality_metrics_id = $value['metric_id'] ;
            $metric->save();
          }        
        }
        if(isset($value['r_quality_id'])){
          if(isset($value['r_detail_id'])){
            $metric = QualityDetail::find($value['r_detail_id']);
            $metric->value = $value['r_value'];
            $metric->save();
          }else if($value['r_value']!=0){
            $metric = new QualityDetail();
            $metric->quality_id = $value['r_quality_id'];
            $metric->value = $value['r_value'];
            $metric->quality_metrics_id = $value['metric_id'] ;
            $metric->save();
          }        
        }else{        
          if($key==0){
            if($req->contract_id){
              $quality = new Quality();
              $quality->contract_id = $req->contract_id;
              $quality->status = 'a';
              $quality->type = 't';
              $quality->save();
              $x = Quality::where('type','t')->orderBy('created_at', 'desc')->first();
              $t_quality_id = $x->id;

              $quality = new Quality();
              $quality->contract_id = $req->contract_id;
              $quality->status = 'a';
              $quality->type = 'r';
              $quality->save();
              $y = Quality::where('type','r')->orderBy('created_at', 'desc')->first();
              $r_quality_id = $y->id;          
            }
          }

          if($value['t_value']!=0){
            $metric = new QualityDetail();
            $metric->quality_id = $t_quality_id;
            $metric->value = $value['t_value'];
            $metric->quality_metrics_id = $value['metric_id'] ;
            $metric->save();
          }
          if($value['r_value']!=0){
            $metric = new QualityDetail();
            $metric->quality_id = $r_quality_id;
            $metric->value = $value['r_value'];
            $metric->quality_metrics_id = $value['metric_id'] ;
            $metric->save();
          }    
        }
      }      
    }

    

    // return response()->json($metric, 200);
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
}

