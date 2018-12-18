<?php

namespace App\Http\Controllers;

use App\Model\Shipment;
use App\Model\ShipmentHistory;
use App\Model\ShipmentLog;
use App\Model\Contract;
use App\Model\ShipmentPlan;
use App\Model\Quality;
use App\Model\Vessel;
use App\Model\SalesTarget;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use PDF;
use Excel;

use Carbon\Carbon;
use DB;
use DateTime;
use DateTimeZone;

/*
* Aryo Pradipta Gema 17 January 2017 13.00
*
* Controller to handle Shipment and Shipment History
*/
class ShipmentController extends Controller
{
    public function __construct() {
      $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected function buyerCodes ($req){
      $shipments = Shipment::select('buyer_code');
      if($req->q) $shipments->where('buyer_code', 'LIKE', '%'.$req->q.'%');

      return response()->json($shipments->get(), 200);
    }

    private function retrieval(Request $req, $pagination) {
      if($req->buyer_codes) return $this->buyerCodes($req);

      $range = [];
      $shipments = Shipment::with('contracts.area', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products', 'qualities.qualityDetail.qualityMetric', 'invoices', 'vessel', 'loader', 'latest_shipment_log')
      ->where(function($q) {
        $q->where('status', 'a')->orWhere('status', 'f');
      })->whereDoesntHave('latest_shipment_log', function($q) {
        $q->where('shipment_status','x');
      });

      if($req->statusUpdate) {
        $shipments = $shipments->with(['shipment_log' => function($q) {
          $q->latest();
        }]);
      }

      // if($req->statusShipment) {
      //   $shipments = $shipments->with('latest_shipment_log');
      // }

      // Document Controller
      // Created by Myrtyl
      // 07/02/2017
      if($req->documents) $shipments->with(['documents' => function($q) {
        $q->where('status', 'a');
      }]);

      $limit = $req->pageSize ? $req->pageSize : 10;
      $skip = ( $req->pageSize * $req->page ) ? ( $req->pageSize * $req->page ) : 0;

      if($req->area_id) $shipments = $shipments->whereHas('supplier', function($q) use ($req) { $q->whereRaw('area_id = '.$req->area_id); });

      //untuk blending
      if($req->blending_area_id) $shipments = $shipments->whereHas('customer', function($q) use ($req) { $q->whereRaw('area_id = '.$req->blending_area_id); });

      if($req->company_id) $shipments = $shipments->whereRaw('supplier_id = "'.$req->company_id.'"');

      //untuk blending
      if($req->customer_id) $shipments = $shipments->whereRaw('customer_id = "'.$req->customer_id.'"');
      // Myrtyl 24 Jan 2017
      // Global Search

      // Ivi 02 May 2017
       if($req->customer) $shipments = $shipments->whereRaw('customer_id = "'.$req->customer.'"');
       if($req->surveyor) $shipments = $shipments->whereRaw('surveyor_id = "'.$req->surveyor.'"');

      /* Kamal 21-02-2017
       */
      if($req->startDatePlan) {
        $param = date("Y-m-d", strtotime($req->startDatePlan));
        $shipments = $shipments->where(function($q) use ($param) {
          $q->where('laycan_start_plan','>=',$param)->orWhere('laycan_end_plan','>=',$param);
        });
      }

      if($req->startDateActual) {
        $param = date("Y-m-d", strtotime($req->startDateActual));
        $shipments = $shipments->where(function($q) use ($param) {
          $q->where('laycan_start_actual','>=',$param)->orWhere('laycan_end_actual','>=',$param);
        });
      }

      // default shipping schedule. (this month start date. ex: 2017-3-1)
      // else if(!$req->startDate&&$req->shipping_schedule) {
      //   $req->startDate = new DateTime(date('Y-m-01'));
      //   // $req->startDate->setTimezone(new DateTimeZone('UTC'));
      //   // return response()->json($req->startDate, 400);
      //   $shipments->where('laycan_start','>=',$req->startDate);
      // }

      if($req->endDatePlan) {
        $param = date("Y-m-d", strtotime($req->endDatePlan . '+1 day'));
        $shipments = $shipments->where(function($q) use ($param) {
          $q->where('laycan_start_plan','<=',$param)->orWhere('laycan_end_plan','<=',$param);
        });
      }

      if($req->endDateActual) {
        $param = date("Y-m-d", strtotime($req->endDateActual . '+1 day'));
        $shipments = $shipments->where(function($q) use ($param) {
          $q->where('laycan_start_actual','<=',$param)->orWhere('laycan_end_actual','<=',$param);
        });
      }

      // default shipping schedule. (this month end date. ex: 2017-3-31)
      // else if(!$req->endDate&&$req->shipping_schedule) {
      //   $req->endDate = date('Y-m-t');
      //   $shipments->where('laycan_end','<=',$req->endDate);
      // }
      if($req->status) {
        $shipments->where('status',$req->status);
      }

      if($req->statusShipment){
        if($req->pre=='true'){
          if($req->shipment_status=='no status'){
            $shipments->where('shipment_status', null);
          }else if($req->shipment_status==null){
            $shipments->where('shipment_status', '<>', 'd')->OrWhere('shipment_status', null);               
          }else if($req->shipment_status!='all'){
            $shipments->where('shipment_status', $req->shipment_status);        
          }        
        }else{
          if($req->shipment_status=='no status'){
            $shipments->where('shipment_status', null);
          }else if($req->shipment_status==null){          
            $shipments->where('shipment_status', 'd');               
          }else if($req->shipment_status!='all'){
            $shipments->where('shipment_status', $req->shipment_status);        
          }
        }

      }

      if($req->area) {
        $shipments->whereHas('contracts', function($q) use ($req) {
          $q->where('area_id', $req->area);
        });
        // return response()->json($shipments->get(), 200);
      }

      if($req->product) {
        $shipments->where('product_variant_id', $req->product);
      }

      if($req->variant) {
        $shipments->where('product_variant_id', $req->variant);
      }

      if($req->country) {
        $shipments->whereHas('customer', function($q) use ($req) {
          $q->where('country', '=' ,$req->country);
        });
      }

      if($req->contract){
        $shipments->whereHas('contracts',function($q) use ($req){
          $q->where('label',$req->contract);
        });
      }

      if($req->q){
        if($req->documents) {
          $param = $req->q;
          $shipments = $shipments->where(function($query) use ($param){
            return $query->whereHas('customer', function($q) use ($param) {
                $q->whereRaw('`company_name` LIKE "%'.$param.'%"');
              })
              ->orWhereHas('products', function($q) use ($param) {
                $q->whereRaw('`name_product_variant` LIKE "%'.$param.'%"');
              })
              ->orWhereHas('vessel', function($q) use ($param) {
                $q->whereRaw('`vessel_name` LIKE "%'.$param.'%"');
              })
              ->orWhereHas('loader', function($q) use ($param) {
                $q->whereRaw('`loader_name` LIKE "%'.$param.'%"');
              })
              ->orWhereRaw('laycan_start_plan LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_end_plan LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_start_actual LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_end_actual LIKE "%'.$param.'%"')
              ->orWhereRaw('eta LIKE "%'.$param.'%"')
              ->orWhereRaw('shipment_no LIKE "%'.$param.'%"');
          });
        }
        else if($req->blending){
          $param = $req->q;
          $shipments = $shipments->where(function($query) use ($param){
            return $query->whereHas('customer', function($q) use ($param) {
                $q->whereRaw('`company_name` LIKE "%'.$param.'%"');
              })
              ->orWhereHas('vessel', function($q) use ($param) {
                $q->whereRaw('`vessel_name` LIKE "%'.$param.'%"');
              })
              ->orWhereHas('loader', function($q) use ($param) {
                $q->whereRaw('`loader_name` LIKE "%'.$param.'%"');
              })
              ->orWhereRaw('laycan_start_plan LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_end_plan LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_start_actual LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_end_actual LIKE "%'.$param.'%"')
              ->orWhereRaw('volume LIKE "%'.$param.'%"');
          });
        }
        else if($req->shipping_schedule){
          $param = $req->q;
          $shipments = $shipments->where(function($query) use ($param){
            return $query->whereHas('contracts', function($q) use ($param) {
                $q->whereRaw('`contract_no` LIKE "%'.$param.'%"');
              })
              ->orwhereHas('customer', function($q) use ($param) {
                $q->whereRaw('`company_name` LIKE "%'.$param.'%"');
              })
              ->orwhereHas('products', function($q) use ($param) {
                $q->whereRaw('`name_product_variant` LIKE "%'.$param.'%"');
              })
              ->orwhereHas('surveyors', function($q) use ($param) {
                $q->whereRaw('`company_name` LIKE "%'.$param.'%"');
              })
              ->orWhereHas('vessel', function($q) use ($param) {
                $q->whereRaw('`vessel_name` LIKE "%'.$param.'%"');
              })
              ->orWhereHas('loader', function($q) use ($param) {
                $q->whereRaw('`loader_name` LIKE "%'.$param.'%"');
              })
              ->orWhereRaw('laycan_start_plan LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_end_plan LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_start_actual LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_end_actual LIKE "%'.$param.'%"')
              ->orWhereRaw('volume LIKE "%'.$param.'%"')
              ->orWhereRaw('demurrage_rate LIKE "%'.$param.'%"')
              ->orWhereRaw('loading_rate LIKE "%'.$param.'%"')
              ->orWhereRaw('price LIKE "%'.$param.'%"')
              ->orWhereRaw('shipment_no LIKE "%'.$param.'%"');
          });
        }
        else{
          $param = $req->q;
          $shipments = $shipments->where(function($query) use ($param){
            return $query->whereHas('contracts', function($q) use ($param) {
                $q->whereRaw('`contract_no` LIKE "%'.$param.'%"');
              })
              ->orwhereHas('supplier', function($q) use ($param) {
                $q->whereRaw('`company_name` LIKE "%'.$param.'%"');
              })
              ->orWhereRaw('laycan_start_plan LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_end_plan LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_start_actual LIKE "%'.$param.'%"')
              ->orWhereRaw('laycan_end_actual LIKE "%'.$param.'%"')
              ->orWhereRaw('shipment_no LIKE "%'.$param.'%"');
          });

        }
      }

      if($req->scheduled) {
        if($req->range) {
          $range = explode(',', $req->range);
          $from = explode('-', $range[0]);
          $till = explode('-', $range[1]);
          $monthFrom = $from[0]; $yearFrom = $from[1];
          $monthTill = $till[0]; $yearTill = $till[1];
          $fromDate = new Carbon('first day of ' . $monthFrom . ' ' . $yearFrom);
          $tillDate = new Carbon('last day of ' . $monthTill . ' ' . $yearTill);
          $shipments = $shipments->whereBetween(DB::raw('date(laycan_start_plan)'), [$fromDate, $tillDate])
            ->orWhereBetween(DB::raw('date(laycan_end_plan)'), [$fromDate, $tillDate])
            ->orWhereBetween(DB::raw('date(laycan_start_actual)'), [$fromDate, $tillDate])
            ->orWhereBetween(DB::raw('date(laycan_end_actual)'), [$fromDate, $tillDate]);
        }
        else
          $shipments = $shipments
            ->where( DB::raw('MONTH(laycan_start_plan)'), '=', date('n') )
            ->where( DB::raw('MONTH(laycan_end_plan)'), '=', date('n') )
            ->where( DB::raw('MONTH(laycan_start_actual)'), '=', date('n') )
            ->orWhere( DB::raw('MONTH(laycan_end_actual)'), '=', date('n') );


      }

      //filter date
      // if($req->startEtcDate)  {
      //   $shipments = $shipments->where('etc','>=', $req->startEtcDate = date("Y-m-d", strtotime($req->startEtcDate)));
      // }
      // if($req->endEtcDate) {
      //   $shipments = $shipments->where('etc','<=', $req->endEtcDate = date("Y-m-d", strtotime($req->endEtcDate . '+1 day')));
      // }
      if($req->startEtcDate)  {
        $shipments = $shipments->where('etc','>=', $req->startEtcDate);
      }
      if($req->endEtcDate) {
        $shipments = $shipments->where('etc','<=', $req->endEtcDate);
      }
      if($req->startEtaDate)  {
        $shipments = $shipments->where('eta','>=', $req->startEtaDate);
      }
      if($req->endEtaDate) {
        $shipments = $shipments->where('eta','<=', $req->endEtaDate);
      }
      if($req->month && $req->year){
        $shipments = $shipments->whereMonth('etc','=',$req->month)->whereYear('etc','=',$req->year);
      }
      if($req->year){
        $shipments = $shipments->whereYear('etc','=',$req->year);
      }

      if($req->month_ld && $req->year_ld){
        $month = $req->month_ld;
        $year = $req->year_ld;
        $shipments = $shipments->where(function($q) use ($month) {
          $q->where(DB::raw('MONTH(laycan_start_plan)'),'=',$month)
          ->orWhere(DB::raw('MONTH(laycan_end_plan)'),'=',$month)
          ->orWhere(DB::raw('MONTH(laycan_start_actual)'),'=',$month)
          ->orWhere(DB::raw('MONTH(laycan_end_actual)'),'=',$month);
        })->where(function($q) use ($year) {
          $q->where(DB::raw('YEAR(laycan_start_plan)'),'=',$year)
          ->orWhere(DB::raw('YEAR(laycan_end_plan)'),'=',$year)
          ->orWhere(DB::raw('YEAR(laycan_start_actual)'),'=',$year)
          ->orWhere(DB::raw('YEAR(laycan_end_actual)'),'=',$year);
        });
      }
      $shipments = $shipments->orderBy('laycan_start_plan');
      if($pagination) $shipments = $shipments->skip($skip)->take($limit)->get();
      else return $shipments->get();

      return $shipments;
    }

    /**
    * Aryo Pradipta Gema 18 January 2017 12.05
    * This index will handle data retrieval based on request parameter given by the frontend
    *
    * params:
    * $req->range = string
    * (ex: 'dec-2016,feb-2017' -> 'december 2016 to february 2017' , 'nov-2015,may-2017' -> 'november 2015 to may 2017')
    **/
    public function index(Request $req)
    {
      if($req->status_log){
        $shipment_log = ShipmentLog::with('shipments', 'shipments.customer', 'shipments.supplier', 'shipments.contracts', 'users', 'shipments.products');

        if($req->startDate) {
          $param = $req->startDate;
          $shipment_log = $shipment_log->whereHas('shipments', function($q) use($param) {
            $q->where('laycan_start_plan', '>=', $param)
            ->orWhere('laycan_end_plan', '>=', $param)
            ->orWhere('laycan_start_actual', '>=', $param)
            ->orWhere('laycan_end_actual', '>=', $param)
            ->orWhere('eta', '>=', $param);
          })->orWhere('shipment_status', '!=', 'f');
        }
        if($req->endDate) {
          $param = $req->endDate;
          $shipment_log = $shipment_log->whereHas('shipments', function($q) use($param) {
            $q->where('laycan_start_plan', '<=', $param)
            ->orWhere('laycan_end_actual', '<=', $param)
            ->orWhere('laycan_start_actual', '<=', $param)
            ->orWhere('laycan_end_actual', '<=', $param)
            ->orWhere('eta', '<=', $param);
          })->orWhere('shipment_status', '!=', 'f');
        }

        $shipment_log = $shipment_log->get();
        return response()->json($shipment_log, 200);
      }
      if($req->type == 'xls' && $req->report) return $this->getXlsReport($req);
      if($req->type == 'xls') return $this->getXls($req);
      if($req->type == 'pdf' && $req->report) return $this->getPdfReport($req);
      if($req->type == 'pdf' && !$req->royalty) return $this->getPdf($req);

      if($req->type == 'pdf' && $req->royalty) return $this->getPdfRoyalty($req);
      // dd($req->report);

      $shipments = $this->retrieval($req, TRUE);

      // if($req->statusShipment){
      //   $shipment_ = [];
      //   foreach ($shipments as $key => $s) {
      //     foreach ($s->shipment_log as $key2 => $value) {
      //       echo $value->shipment_status;
      //       // if ($value[$key2]->shipment_status=='DEPARTED'){
      //       //   echo "oke";
      //       //   echo $key;
      //       // }
      //     }
      //     // if(isset($s->shipment_log))
      //     // $shipment_[$key] =  $s->shipment_log;
      //   }
      //   dd();
      //   // return($shipment_);
      //   return response()->json($shipment_);
      // }

      return response()->json($shipments, 200);
    }

    public function showShipmentProducts(Request $req)
    {
       $shipments = Shipment::with('contracts.area', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products', 'qualities.qualityDetail.qualityMetric', 'invoices', 'vessel', 'latest_shipment_log')
       ->whereHas(
         'latest_shipment_log', function($q){
           $q->where('shipment_status', 'f');
         }
       )
      ->where(function($q) {
        $q->where('status', 'a')->orWhere('status', 'f');
      });
      $salesTarget = SalesTarget::with('product_variant')->where('tonnage','!=',0);

      if($req->month==='0') {
        $req->month=false;
        $array_product_month = [];
        $array_tonnage_month = [];
        $array_averagePrice_month = [];
        $totalTonnageMonth = 0;
        $achivementTonnageMonth = 0;
        $averagePerProductMont = [];
        $averagePerProductTonnageMonth = [];
        $averageSellPriceMonth = 0;
        $array_averagePrice_month = [];
      }

      if($req->year){

        $salesTargetYear = $salesTarget->where('year','=',$req->year);
        $targetTonnageYear = $salesTargetYear->sum('tonnage');

        $arraySales_product_year = [];
        $arraySales_tonnage_year = [];
        $i=0;

        foreach ($salesTargetYear->get() as $py) {
          if($i===0) {
            $arraySales_product_year[$i] = $py->product_variant->name_product_variant;
            $arraySales_tonnage_year[$i] = $py->tonnage;
            $i++;
          }
          else {
            $h=0;
            for ($k=0;$k<count($arraySales_product_year);$k++) {
              if($arraySales_product_year[$k]===$py->product_variant->name_product_variant) {
                $arraySales_tonnage_year[$k] = $arraySales_tonnage_year[$k]+$py->tonnage;
                $h=1;
                break;
              }
            }
            if($h===0) {
              $arraySales_product_year[$i] = $py->product_variant->name_product_variant;
              $arraySales_tonnage_year[$i] = $py->tonnage;
              $i++;
            }
          }

        }

        $productYear = $shipments->whereYear('etc','=',$req->year);
        $totalTonnageYear = $productYear->sum('volume');

        $achivementTonnageYear = $targetTonnageYear===0 ? 0 : ($totalTonnageYear/$targetTonnageYear)*100;

        $array_product_year = [];
        $array_tonnage_year = [];
        $array_averagePrice_year = [];
        $i = 0;
        $sellyear =0;

        foreach ($productYear->get() as $py) {
          $price = $py->contracts->orders->sells[0]->pivot->price;
          $tonnage = $py->volume;
          $sellyear = $sellyear + ($price*$tonnage);
          if($i===0) {
            $array_product_year[$i] = $py->products->name_product_variant;
            $array_tonnage_year[$i] = $py->volume;
            $array_averagePrice_year[$i] = $price*$tonnage;
            $i++;
          }
          else {
            $h=0;
            for ($k=0;$k<count($array_product_year);$k++) {
              if($array_product_year[$k]===$py->products->name_product_variant) {
                $array_tonnage_year[$k] = $array_tonnage_year[$k]+$py->volume;
                $array_averagePrice_year[$k] = $array_averagePrice_year[$k]+($price*$tonnage);
                $h=1;
                break;
              }
            }
            if($h===0) {
              $array_product_year[$i] = $py->products->name_product_variant;
              $array_tonnage_year[$i] = $py->volume;
              $array_averagePrice_year[$i] = $price*$tonnage;
              $i++;
            }
          }

        }


        $l=0;
        foreach ($array_tonnage_year as $ton) {
          $array_averagePrice_year[$l] = $array_averagePrice_year[$l]/$ton;
          $l++;
        }

        $averageSellPriceYear = $totalTonnageYear===0 ? 0 : $sellyear/$totalTonnageYear;

        $k=0;
        $averagePerProductYear = [];
        $averagePerProductTonnageYear = [];
        foreach ($arraySales_product_year as $sale) {
          $averagePerProductYear[$k] = $sale;
          $averagePerProductTonnageYear[$k] = 0;
          $j=0;
          foreach ($array_product_year as $product) {
            if($sale===$product) {
              $averagePerProductTonnageYear[$k] = ($array_tonnage_year[$j]/$arraySales_tonnage_year[$k])*100;
            }
            $j++;
          }
          $k++;
        }

      }



      if($req->month){

        $salesTargetMonth = $salesTarget->where('year','=',$req->year)->where('month','=',$req->month);
        $targetTonnageMonth = $salesTargetMonth->sum('tonnage');

        $arraySales_product_month = [];
        $arraySales_tonnage_month = [];
        $i=0;

        foreach ($salesTargetMonth->get() as $py) {
          if($i===0) {
            $arraySales_product_month[$i] = $py->product_variant->name_product_variant;
            $arraySales_tonnage_month[$i] = $py->tonnage;
            $i++;
          }
          else {
            $h=0;
            for ($k=0;$k<count($arraySales_product_month);$k++) {
              if($arraySales_product_month[$k]===$py->product_variant->name_product_variant) {
                $arraySales_tonnage_month[$k] = $arraySales_tonnage_month[$k]+$py->tonnage;
                $h=1;
                break;
              }
            }
            if($h===0) {
              $arraySales_product_month[$i] = $py->product_variant->name_product_variant;
              $arraySales_tonnage_month[$i] = $py->tonnage;
              $i++;
            }
          }

        }

        $productMonth = $shipments->whereMonth('etc','=',$req->month)->whereYear('etc','=',$req->year);
        $totalTonnageMonth = $productMonth->sum('volume');

        $achivementTonnageMonth = $targetTonnageMonth===0 ? 0 : ($totalTonnageMonth/$targetTonnageMonth)*100;

        $array_product_month = [];
        $array_tonnage_month = [];
        $array_averagePrice_month = [];
        $i = 0;
        $sellmonth =0;

        foreach ($productMonth->get() as $py) {
          $price = $py->contracts->orders->sells[0]->pivot->price;
          $tonnage = $py->volume;
          $sellmonth = $sellmonth + ($price*$tonnage);
          if($i===0) {
            $array_product_month[$i] = $py->products->name_product_variant;
            $array_tonnage_month[$i] = $py->volume;
            $array_averagePrice_month[$i] = $tonnage*$price;
            $i++;
          }
          else {
            $h=0;
            for ($k=0;$k<count($array_product_month);$k++) {
              if($array_product_month[$k]===$py->products->name_product_variant) {
                $array_tonnage_month[$k] = $array_tonnage_month[$k]+$py->volume;
                $array_averagePrice_month[$k] = $array_averagePrice_month[$k]+($tonnage*$price);
                $h=1;
                break;
              }
            }
            if($h===0) {
              $array_product_month[$i] = $py->products->name_product_variant;
              $array_tonnage_month[$i] = $py->volume;
              $array_averagePrice_month[$i] = $tonnage*$price;
              $i++;
            }
          }

        }

        $l=0;
        foreach ($array_tonnage_month as $ton) {
          $array_averagePrice_month[$l] = $array_averagePrice_month[$l]/$ton;
          $l++;
        }

        $averageSellPriceMonth = $totalTonnageMonth===0 ? 0 : $sellmonth/$totalTonnageMonth;

        $k=0;
        $averagePerProductMont = [];
        $averagePerProductTonnageMonth = [];
        foreach ($arraySales_product_month as $sale) {
          $averagePerProductMont[$k] = $sale;
          $averagePerProductTonnageMonth[$k] = 0;
          $j=0;
          foreach ($array_product_month as $product) {
            if($sale===$product) {
              $averagePerProductTonnageMonth[$k] = ($array_tonnage_year[$j]/$arraySales_tonnage_year[$k])*100;
            }
            $j++;
          }
          $k++;
        }


      }

      $shipments = new Shipment();
      $shipments->productYear = $array_product_year;
      $shipments->productTonnageYear = $array_tonnage_year;
      $shipments->productMonth = $array_product_month;
      $shipments->productTonnageMonth = $array_tonnage_month;
      $shipments->totalTonnageMonth = $totalTonnageMonth;
      $shipments->totalTonnageYear = $totalTonnageYear;
      $shipments->achivementTonnageMonth = $achivementTonnageMonth;
      $shipments->achivementTonnageYear = $achivementTonnageYear;
      $shipments->averagePerProductYear = $averagePerProductYear;
      $shipments->averagePerProductTonnageYear = $averagePerProductTonnageYear;
      $shipments->averagePerProductMont = $averagePerProductMont;
      $shipments->averagePerProductTonnageMonth = $averagePerProductTonnageMonth;
      $shipments->averageSellPriceYear = $averageSellPriceYear;
      $shipments->averageSellPriceMonth = $averageSellPriceMonth;
      $shipments->averageSellPriceProductYear = $array_averagePrice_year;
      $shipments->averageSellPriceProductMonth = $array_averagePrice_month;

      return response()->json($shipments, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $shipment = new Shipment();

        $shipment->contract_id = $request->contract_id;
        $shipment->supplier_id = $request->supplier_id;
        $shipment->customer_id = $request->customer_id;
        $shipment->product_variant_id = $request->product_variant_id;
        $shipment->surveyor_id = $request->surveyor_id;
        $shipment->buyer_code = $request->buyer_code;
        $shipment->shipment_no = $request->shipment_no;
        $shipment->vessel_id = $request->vessel_id;
        $shipment->loader_id = $request->loader_id;
        $shipment->laycan_start_plan = $request->laycan_start_plan;
        $shipment->laycan_end_plan = $request->laycan_end_plan;
        $shipment->laycan_start_actual = $request->laycan_start_actual;
        $shipment->laycan_end_actual = $request->laycan_end_actual;
        $shipment->eta = $request->eta;
        $shipment->etd = $request->etd;
        $shipment->etc = $request->etc;
        $shipment->loaded = $request->loaded;
        $shipment->volume = $request->volume;
        $shipment->demurrage_rate = $request->demurrage_rate;
        $shipment->loading_rate = $request->loading_rate;
        $shipment->currency = $request->currency;
        $shipment->price = $request->price;
        $shipment->bl_date = $request->bl_date;
        $shipment->cargo_bl = $request->cargo_bl;
        $shipment->adv_royalty = 0;
        $shipment->status = 'a';

        $shipment->save();

        $shipment_history = $this->storeShipmentHistory($shipment);

        $shipment = Shipment::with('contracts', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products')->find($shipment->id);

        return response()->json($shipment, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id)
     {
        $shipment = Shipment::with('contracts', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products', 'shipment_history.surveyors', 'qualities.qualityDetail.qualityMetric', 'invoices', 'vessel', 'loader')
       ->where(function($q) {
         $q->where('status', 'a')->orWhere('status', 'f');
       })->find($id);

        foreach ($shipment->shipment_history as $h) {
          $h->vessel = json_decode($h->vessel);
         # code...
       }
       // dd();

        return response()->json($shipment, 200);
     }

    public function showQualityInvoice(Request $req,$id)
    {
        $shipment = Shipment::with('contracts', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products', 'shipment_history', 'qualities.qualityDetail.qualityMetric', 'invoices')
      ->where(function($q) {
        $q->where('status', 'a')->orWhere('status', 'f');
      })->find($id);


      // $i=0;
      // $j=0;
      // $qual = [];
      //
      //
      // $invoice = $shipment->Invoices;
      // if($invoice) {
      //   $invoice = $shipment->Invoices->price_calculation;
      //   foreach ($shipment->qualities as $quality) {
      //     $i=0;
      //     $detail = [];
      //     foreach ($quality->qualityDetail as $q_detail) {
      //       $point=1;
      //       foreach ($invoice as $in) {
      //         if($q_detail->quality_metrics_id===$in['quality_metric_id']) {
      //           $point = 0;
      //           break;
      //         }
      //
      //       }
      //       if($point!==0) {
      //         $detail[$i] = $q_detail;
      //         $i++;
      //       }
      //     }
      //     if($detail!==NULL) {
      //       $shipment->qualities[$j]->qual=$detail;
      //       $j++;
      //     }
      //
      //   }
      // }
      // else {
      //   foreach ($shipment->qualities as $quality) {
      //     $i=0;
      //     $detail = [];
      //     foreach ($quality->qualityDetail as $q_detail) {
      //       $detail[$i] = $q_detail;
      //       $i++;
      //     }
      //     $shipment->qualities[$j]->qual=$detail;
      //     $j++;
      //   }
      // }

      $invoice = $shipment->Invoices;
      if($invoice) {
        $invoicePrice = $shipment->Invoices->price_calculation;
        $invoiceTonnage = $shipment->Invoices->tonnage_calculation;

        $j=0;
        foreach ($shipment->qualities as $quality) {
          $i=0;
          $detail = [];
          foreach ($quality->qualityDetail as $q_detail) {
            $point=1;
            foreach ($invoicePrice as $in) {
              if($q_detail->quality_metrics_id===$in['quality_metric_id']) {
                $point = 0;
                break;
              }

            }
            if($point!==0) {
              $detail[$i] = $q_detail;
              $i++;
            }
          }
          if($detail!==NULL) {
            $shipment->qualities[$j]->priceInvoice=$detail;
            $j++;
          }

        }

        $j=0;
        foreach ($shipment->qualities as $quality) {
          $i=0;
          $detail = [];
          foreach ($quality->qualityDetail as $q_detail) {
            $point=1;
            foreach ($invoiceTonnage as $in) {
              if($q_detail->quality_metrics_id===$in['quality_metric_id']) {
                $point = 0;
                break;
              }

            }
            if($point!==0) {
              $detail[$i] = $q_detail;
              $i++;
            }
          }
          if($detail!==NULL) {
            $shipment->qualities[$j]->tonnageInvoice=$detail;
            $j++;
          }

        }
      }
      else {
        foreach ($shipment->qualities as $quality) {
          $i=0;
          $detail = [];
          foreach ($quality->qualityDetail as $q_detail) {
            $detail[$i] = $q_detail;
            $i++;
          }
          $shipment->qualities[$j]->qual=$detail;
          $j++;
        }
      }

      return response()->json($shipment, 200);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
     {
       $shipment = Shipment::with('contracts', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products')->find($id);

      $shipment->fill($request->all());

      $shipment->save();

      $shipment_history = $this->storeShipmentHistory($shipment);

      return $this->show($id);

      //return response()->json(['shipment' => $shipment, 'shipment_history' => $shipment_history], 200);
     }

    /*
    * Aryo Pradipta Gema 19 January 2017 14.11
    * to store ShipmentHistory
    * no params
    */
    private function storeShipmentHistory($shipment) {
      $shipment_history = new ShipmentHistory();
      $shipment_history->shipment_id = $shipment->id;
      $shipment_history->user_id = Auth::user()->id;
      $shipment_history->contract_id = $shipment->contract_id;
      $shipment_history->supplier_id = $shipment->supplier_id;
      $shipment_history->customer_id = $shipment->customer_id;
      $shipment_history->product_variant_id = $shipment->product_variant_id;
      $shipment_history->surveyor_id = $shipment->surveyor_id;
      $shipment_history->vessel = $shipment->vessel;
      $shipment_history->loader_id = $shipment->loader_id;
      $shipment_history->laycan_start_actual = $shipment->laycan_start_actual;
      $shipment_history->laycan_end_actual = $shipment->laycan_end_actual;
      $shipment_history->laycan_start_plan = $shipment->laycan_start_plan;
      $shipment_history->laycan_end_plan = $shipment->laycan_end_plan;
      // $shipment_history->laycan_start_actual = $shipment->laycan_start_actual; //di seedernya belum ada fiel ini
      // $shipment_history->laycan_end_actual = $shipment->laycan_end_actual; //di seedernya belum ada fiel ini
      $shipment_history->eta = $shipment->eta;
      $shipment_history->etd = $shipment->etd;
      $shipment_history->etc = $shipment->etc;
      $shipment_history->remark = $shipment->remark;
      $shipment_history->volume = $shipment->volume;
      $shipment_history->demurrage_rate = $shipment->demurrage_rate;
      $shipment_history->loading_rate = $shipment->loading_rate;
      $shipment_history->price = $shipment->price;
      $shipment_history->status = $shipment->status;
      $shipment_history->save();

      return $shipment_history;
    }

    /*
    * Aryo Pradipta Gema 19 January 2017 14.11
    * to retrieve ShipmentHistory in bulk where the status is 'a'
    * no params
    */
    // public function indexShipmentHistory() {
    //   $shipment_histories = ShipmentHistory::with('shipments', 'shipments.contracts', 'shipments.supplier', 'shipments.customer', 'surveyors', 'shipments.products')->get();
    //   return response()->json($shipment_histories, 200);
    // }

    /*
    * Aryo Pradipta Gema 19 January 2017 14.11
    * to retrieve one ShipmentHistory based on id where the status is 'a'
    * params :
    * $id from routes is shipment history id
    */
    public function showShipmentHistory($id) {
      $shipment_history = ShipmentHistory::with('shipments', 'shipments.contracts', 'shipments.supplier', 'shipments.customer', 'surveyors', 'shipments.products')->find($id);

      return response()->json($shipment_history, 200);
    }

    /*
    * Aryo Pradipta Gema 19 January 2017 14.11
    * to retrieve ShipmentHistory in bulk where the status is 'a' based on their shipment
    * params:
    * $id from routes is shipment id
    */
    // public function showShipmentHistoryByShipment($id) {
    //   $shipment_history = ShipmentHistory::with('shipments', 'shipments.contracts', 'surveyors', 'shipments.products')->where('shipment_id', $id)->get();

    //   return response()->json($shipment_history, 200);
    // }

    /*
    * Aryo Pradipta Gema 19 January 2017 14.11
    * to store ShipmentLog
    * no params
    */
    public function storeShipmentLog(Request $request, $id) {
      $shipment_log = new ShipmentLog();
      $shipment_log->shipment_id = $id;
      $shipment_log->user_id = Auth::user()->id;
      $shipment_log->stowage_plan = $request->stowage_plan;
      $shipment_log->cargo_status = $request->cargo_status;
      $shipment_log->cargo_supply = $request->cargo_supply;
      $shipment_log->remark = $request->remark;
      $shipment_log->shipment_status = $request->shipment_status;
      $shipment_log->save();


      $shipment = Shipment::find($id);
      if($request->shipment_status == 'x') {

        $shipment_plan = new ShipmentPlan();
        $shipment_plan->contract_id = $shipment->contract_id;
        $shipment_plan->product_variant_id = $shipment->product_variant_id;
        $shipment_plan->laycan_start = $shipment->laycan_start_plan;
        $shipment_plan->laycan_end = $shipment->laycan_end_plan;
        $shipment_plan->volume = $shipment->volume;
        $shipment_plan->status = 'a';
        $shipment_plan->save();
      }

      $shipment->shipment_status = $request->shipment_status;
      $shipment->save();
      

      return response()->json($shipment_log,200);
    }

    /*
    * Aryo Pradipta Gema 19 January 2017 14.11
    * to retrieve ShipmentLog in bulk
    * no params
    */
    // public function indexShipmentLog(Request $req) {
    //   $shipment_log = ShipmentLog::with('shipments', 'shipments.customer', 'shipments.supplier', 'shipments.contracts', 'users', 'shipments.products');

    //   if($req->startDate) {
    //     $param = $req->startDate;
    //     $shipment_log = $shipment_log->whereHas('shipments', function($q) use($param) {
    //       $q->where('laycan_start', '>=', $param)->orWhere('laycan_end', '>=', $param)->orWhere('eta', '>=', $param);
    //     })->orWhere('shipment_status', '!=', 'COMPLETE');
    //   }
    //   if($req->endDate) {
    //     $param = $req->endDate;
    //     $shipment_log = $shipment_log->whereHas('shipments', function($q) use($param) {
    //       $q->where('laycan_start', '<=', $param)->orWhere('laycan_end', '<=', $param)->orWhere('eta', '<=', $param);
    //     })->orWhere('shipment_status', '!=', 'COMPLETE');
    //   }

    //   $shipment_log = $shipment_log->get();
    //   return response()->json($shipment_log, 200);
    // }

    /*
    * Aryo Pradipta Gema 19 January 2017 14.11
    * to retrieve ShipmentLog in bulk based on their shipment
    * params:
    * $id from routes is shipment id
    */
    public function showShipmentLogByShipment(Request $req, $id) {
      $shipment_log = ShipmentLog::with('shipments', 'shipments.contracts', 'users', 'shipments.products')->where('shipment_id', $id);
      if($req->latest) $shipment_log = $shipment_log->orderBy('created_at', 'DESC')->first();
      else $shipment_log = $shipment_log->get();

      return response()->json($shipment_log, 200);
    }

    /*
    * Theodorus David 15 March 2017
    * to get & store in shipmentplans
    */
    // public function getShipmentPlans(Request $req, $id)
    // {
    //   $shipment_plan = ShipmentPlan::with('contracts','products')->where('status','a')->find($id);
    //   return response()->json($shipment_plan,200);
    // }

    // public function getAllShipmentPlans(Request $req)
    // {
    //   // return response()->json($req);
    //   $shipment_plan = ShipmentPlan::with('contracts')->where('status','a');
    //   if($req->q){
    //     $param = $req->q;
    //     $shipment_plan = $shipment_plan->where(function($query) use ($param){
    //       $query->whereHas('contracts', function($q) use ($param) {
    //           $q->whereRaw('`contract_no` LIKE "%'.$param.'%"');
    //         })
    //         // ->orwhereHas('customer', function($q) use ($param) {
    //         //   $q->whereRaw('`company_name` LIKE "%'.$param.'%"');
    //         // })
    //         // ->orwhereHas('products', function($q) use ($param) {
    //         //   $q->whereRaw('`product_name` LIKE "%'.$param.'%"');
    //         // })
    //         // ->orwhereHas('surveyors', function($q) use ($param) {
    //         //   $q->whereRaw('`company_name` LIKE "%'.$param.'%"');
    //         // })
    //         // ->orWhereRaw('vessel LIKE "%'.$param.'%"')
    //         ->orWhereRaw('laycan_start LIKE "%'.$param.'%"')
    //         ->orWhereRaw('laycan_end LIKE "%'.$param.'%"')
    //         ->orWhereRaw('volume LIKE "%'.$param.'%"');
    //         // ->orWhereRaw('demurrage_rate LIKE "%'.$param.'%"')
    //         // ->orWhereRaw('loading_rate LIKE "%'.$param.'%"')
    //         // ->orWhereRaw('price LIKE "%'.$param.'%"')
    //         // ->orWhereRaw('shipment_no LIKE "%'.$param.'%"');
    //     });
    //   }

    //   if($req->area) {
    //     $shipment_plan->whereHas('contracts', function($q) use ($req) {
    //       $q->where('area_id', $req->area);
    //     });
    //     // return response()->json($shipments->get(), 200);
    //   }

    //   if($req->contract){
    //     $shipment_plan->whereHas('contracts',function($q) use ($req){
    //       $q->where('label',$req->contract);
    //     });
    //   }
    //   if($req->month_ld && $req->year_ld){
    //     $month = $req->month_ld;
    //     $year = $req->year_ld;
    //     $shipment_plan = $shipment_plan->where(function($q) use ($month) {
    //       $q->where(DB::raw('MONTH(laycan_start)'),'=',$month)->orWhere(DB::raw('MONTH(laycan_end)'),'=',$month);
    //     })->where(function($q) use ($year) {
    //       $q->where(DB::raw('YEAR(laycan_start)'),'=',$year)->orWhere(DB::raw('YEAR(laycan_end)'),'=',$year);
    //     });
    //   }


    //   $shipment_plan = $shipment_plan->get();
    //   return response()->json($shipment_plan,200);
    // }

    // public function storeShipmentPlans(Request $req){
    //   // return response()->json($req);
    //   $shipment_plans = new ShipmentPlan();
    //   $shipment_plans->contract_id = $req->contract_id;
    //   $shipment_plans->product_id = $req->product_id;
    //   $shipment_plans->laycan_start = $req->laycan_start;
    //   $shipment_plans->laycan_end = $req->laycan_end;
    //   $shipment_plans->volume = $req->volume;
    //   $shipment_plans->status = 'a';

    //   $shipment_plans->save();
    //   return response()->json($shipment_plans,200);
    // }

    public function storeShipmentFromPlans(Request $req, $id){
      $shipment_plan = ShipmentPlan::find($id);
      // dd($shipment_plan->contract_id);
      $shipment = new Shipment();

      $shipment->contract_id = $shipment_plan->contract_id;
      $shipment->supplier_id = $req->supplier_id;
      $shipment->customer_id = $req->customer_id;
      $shipment->product_variant_id = $req->product_variant_id;
      $shipment->surveyor_id = $req->surveyor_id;
      $shipment->buyer_code = $req->buyer_code;
      $shipment->shipment_no = $req->shipment_no;
      $shipment->vessel_id = $req->vessel;
      $shipment->loader_id = $req->loader_id;
      $shipment->laycan_start_plan = $req->laycan_start_plan;
      $shipment->laycan_end_plan = $req->laycan_end_plan;
      $shipment->laycan_start_actual = $req->laycan_start_actual;
      $shipment->laycan_end_actual = $req->laycan_end_actual;
      $shipment->eta = $req->eta;
      $shipment->etd = $req->etd;
      $shipment->etc = $req->etc;
      $shipment->loaded = $req->loaded;
      $shipment->volume = $req->volume;
      $shipment->demurrage_rate = $req->demurrage_rate;
      $shipment->loading_rate = $req->loading_rate;
      $shipment->currency = $req->currency;
      $shipment->price = $req->price;
      $shipment->bl_date = $req->bl_date;
      $shipment->cargo_bl = $req->cargo_bl;
      $shipment->status = 'a';

      $shipment_plan->status='x';

      $shipment->save();
      $shipment_plan->save();

      $shipment_history = $this->storeShipmentHistory($shipment);

      $shipment = Shipment::with('contracts', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products')->find($shipment->id);

      return response()->json($shipment, 200);
    }

    // //finalize shipment
    // public function finalizeShipmentByMonth(Request $request)
    // {
    //   $shipments = Shipment::with('contracts', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products')->whereMonth('etc', '=', $request->month)->whereYear('etc', '=',$request->year)->update(['status'=> 'f']);

    //   $shipments = Shipment::with('contracts', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products')->whereMonth('etc', '=', $request->month)->whereYear('etc', '=',$request->year)->get();

    //   return response()->json($shipments, 200);
    // }

    public function finalizeShipmentById(Request $request)
    {
      $shipments = Shipment::with('contracts', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products')->where('id', $request->ship_id)->update(['status'=> 'f']);

      $shipments = Shipment::with('contracts', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products')->where('id', $request->ship_id)->get();

      return response()->json($shipments, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $shipment = Shipment::find($id);

      $shipment->status = 'x';

      $shipment->save();

      $shipment_history = $this->storeShipmentHistory($shipment);

      $shipment_plan = new ShipmentPlan();
      $shipment_plan->contract_id = $shipment->contract_id;
      $shipment_plan->product_variant_id = $shipment->product_variant_id;
      $shipment_plan->laycan_start = $shipment->laycan_start;
      $shipment_plan->laycan_end = $shipment->laycan_end;
      $shipment_plan->volume = $shipment->volume;
      $shipment_plan->status = 'a';

      $shipment_plan->save();

      return response()->json($shipment, 200);
    }

    public function getPdf($req){

      $shipments = $this->retrieval($req, FALSE);

      $numActual = 0;
      $numForecast = 0;
      $numFinished = 0;
      $numCancelled = 0;

      foreach($shipments as $s) {
        if($s->contracts->label == 't') $numForecast++;
        if($s->contracts->label == 'a') $numActual++;
        if($s->status == 'f') $numFinished++;
        if($s->status == 'x') $numCancelled++;
      }

      // return response()->json($shipments, 200);
      if($req->year==0) $req->year = 'All Year';
      // $req->month = 'x';
      $pdf = PDF::loadView('pdf.scheduler', [
        'month' => $req->month,
        'year' => $req->year,
        'shipments' => $shipments,
        'numActual' => $numActual,
        'numForecast' => $numForecast,
        'numFinished' => $numFinished,
        'numCancelled' => $numCancelled
      ])->setPaper('a4', 'landscape');
      return $pdf->stream('scheduler.pdf');
      // $pdf = PDF::loadView('pdf.scheduler');
      // return $pdf->stream('scheduler.pdf');
    }

    public function getPdfReport($req){
      $shipments = $this->retrieval($req, FALSE);

      $numActual = 0;
      $numForecast = 0;
      $numFinished = 0;
      $numCancelled = 0;

      foreach($shipments as $s) {
        if($s->contracts->label == 't') $numForecast++;
        if($s->contracts->label == 'a') $numActual++;
        if($s->status == 'f') $numFinished++;
        if($s->status == 'x') $numCancelled++;
      }

      if($req->year==0) $req->year = 'All Year';

      $pdf = PDF::loadView('pdf.report', [
        'month' => $req->month,
        'year' => $req->year,
        'shipments' => $shipments,
        'numActual' => $numActual,
        'numForecast' => $numForecast,
        'numFinished' => $numFinished,
        'numCancelled' => $numCancelled
      ])->setPaper('a3', 'landscape');
      return $pdf->stream('scheduler.pdf');
      // $pdf = PDF::loadView('pdf.scheduler');
      // return $pdf->stream('scheduler.pdf');
    }


    public function getPdfRoyalty($req){
      $shipments = Shipment::with('contracts.area', 'contracts.orders', 'contracts.orders.sells', 'supplier', 'customer', 'surveyors', 'products', 'products.product', 'qualities.qualityDetail.qualityMetric')
      ->where(function($q) {
        $q->where('status', 'a')->orWhere('status', 'f');
      })->find(explode(',', $req->data));

      $creator = $req->creator;
      $acknowledger = $req->acknowledger;
      $approver = $req->approver;

      $date = Carbon::now();
      $week = $date->weekOfMonth;

      $total_usd = 0;
      $total_idr = 0;
      foreach ($shipments as $s) {
        $total_usd+=$s->currency=='USD'?$s->volume*$s->price:0;
        $total_idr+=$s->currency=='IDR'?$s->volume*$s->price:0;

        $s->adv_royalty = 1;
        $s->save();
      }

      // return response()->json($shipments, 200);
      $pdf = PDF::loadView('pdf.royalty', [
        'shipments' => $shipments,
        'creator' => $creator,
        'acknowledger' => $acknowledger,
        'approver' => $approver,
        'total_usd' => $total_usd,
        'total_idr' => $total_idr,
        'date' => $date,
        'week' => $week
      ])->setPaper('a4', 'landscape');
      return $pdf->stream('Royalty Request ' . $date->toFormattedDateString() . '.pdf');
      // $pdf = PDF::loadView('pdf.scheduler');
      // return $pdf->stream('scheduler.pdf');
    }

    public function getXlsReport($req){
      $shipments = $this->retrieval($req, FALSE);

      $ord = [];

      $numActual = 0;
      $numForecast = 0;
      $numFinished = 0;
      $numCancelled = 0;
      // return($shipments);

      foreach ($shipments as $key=>$s) {
        if($s->contracts->label == 't') $numForecast++;
        if($s->contracts->label == 'a') $numActual++;
        if($s->status == 'f') $numFinished++;
        if($s->status == 'x') $numCancelled++;

        $ord[] = array(
          "No" => $key+1,
          "Contract No." => $s->contracts->contract_no,
          "Customer" => $s->customer->company_name,
          "Country" => $s->customer->country,
          "Shipment No." => $s->shipment_no,
          "Vessel" => $s->vessel->vessel_name,
          "Tot" => $s->volume,
          "Prc" => $s->price,
          "Product Variant" => $s->products->name_product_variant,
          "Delivery Period Plan" => date("d/m/y",strtotime($s->laycan_start_plan))." ~ ".date("d/m/y",strtotime($s->laycan_end_plan)),
          "Delivery Period Actual" => date("d/m/y",strtotime($s->laycan_start_actual))." ~ ".date("d/m/y",strtotime($s->laycan_end_actual)),
          "ETA" => date("d M y",strtotime($s->eta)),
          "ETD" => date("d M y",strtotime($s->etd)),
          "ETC" => date("d M y",strtotime($s->etc))
        );
      }

      if($req->year==0) {
        $year = 'All Year';
      }else{
        $year = $req->year;
      }
      if($req->month==0){
        $month = '';
      }else{
        $month = DateTime::createFromFormat('!m', $req->month)->format('F');
      }
      return Excel::create('Shipping Schedule Report - '.$month.' '.$year, function($excel) use ($ord, $numActual, $numForecast, $numFinished, $numCancelled, $month, $year) {
        $excel->sheet($month.' '.$year, function($sheet) use ($ord, $numActual, $numForecast, $numFinished, $numCancelled) {
          // $sheet->fromArray($ord);
          $sheet->rows([
            $sheet->fromArray($ord),
            /*[''],
            ['Summary'],
            ['Total of Shipment from Actual Contract',$numActual],
            ['Total of Shipment from Contract Forecast',$numForecast],
            ['Total Finished Shipment',$numFinished],
            ['Total Cancelled Shipment',$numCancelled]*/
          ]);
        });
      })->download('xls');
    }

    public function getXls($req){
      // return response()->json($req);
      $shipments = $this->retrieval($req, FALSE);

      $ord = [];

      $numActual = 0;
      $numForecast = 0;
      $numFinished = 0;
      $numCancelled = 0;

      foreach ($shipments as $s) {
        if($s->contracts->label == 't') $numForecast++;
        if($s->contracts->label == 'a') $numActual++;
        if($s->status == 'f') $numFinished++;
        if($s->status == 'x') $numCancelled++;

        $ord[] = array(
          "No" => $s->shipment_no,
          "Client" => $s->customer->company_name,
          "Vessel" => $s->vessel->vessel_name,
          "Delivery Period Plan" => date("d/m/y",strtotime($s->laycan_start_plan))." ~ ".date("d/m/y",strtotime($s->laycan_end_plan)),
          "Delivery Period" => date("d/m/y",strtotime($s->laycan_start_actual))." ~ ".date("d/m/y",strtotime($s->laycan_end_actual)),
          "ETA" => date("d M y",strtotime($s->eta)),
          "ETD" => date("d M y",strtotime($s->etd)),
          "ETC" => date("d M y",strtotime($s->etc)),
          "Brand" => $s->products->name_product_variant,
          "Srvyr" => $s->surveyors->company_name,
          "Tot" => $s->volume,
          "DemRt" => $s->demurrage_rate,
          "C#" => $s->contracts->contract_no,
          "LRt" => $s->loading_rate,
          "Prc" => $s->price,
          "TPrc" => $s->price*$s->volume
        );
      }

      if($req->year==0) {
        $year = 'All Year';
      }else{
        $year = $req->year;
      }
      if($req->month==0){
        $month = '';
      }else{
        $month = DateTime::createFromFormat('!m', $req->month)->format('F');
      }

      return Excel::create('Shipping Schedule - '.$month.' '.$year, function($excel) use ($ord, $numActual, $numForecast, $numFinished, $numCancelled, $month, $year) {
        $excel->sheet($month.' '.$year, function($sheet) use ($ord, $numActual, $numForecast, $numFinished, $numCancelled) {
          // $sheet->fromArray($ord);
          $sheet->rows([
            $sheet->fromArray($ord),
            /*[''],
            ['Summary'],
            ['Total of Shipment from Actual Contract',$numActual],
            ['Total of Shipment from Contract Forecast',$numForecast],
            ['Total Finished Shipment',$numFinished],
            ['Total Cancelled Shipment',$numCancelled]*/
          ]);
        });
      })->download('xls');
    }

}
