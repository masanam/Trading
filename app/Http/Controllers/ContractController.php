<?php

namespace App\Http\Controllers;

use App\Model\Contract;
use App\Model\Order;
use App\Model\Shipment;
use App\Model\Company;
use App\Model\Product;
use App\Model\Lead;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Input;
use Excel;
use DB;
use Auth;

use Carbon\Carbon;

class ContractController extends Controller
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

      if($req->type == 'csv') return $this->getExample();

      if($req->type=='actual'){
        $contract = Contract::with(['qualities' => function($q){
            $q->where('type', 't');
            $q->orWhere('type', 'r');
          },'qualities.qualityDetail', 'qualities.qualityDetail.qualityMetric']);

        $contract=$contract->find($req->contract_id);
        return response()->json($contract, 200);

      }

      $range = [];
      $contracts = Contract::with(['shipments' => function($q) {
       $q->where('status', '!=', 'x');
      }, 'shipment_plans' => function($q) {
       $q->where('status', '!=', 'x');
     }, 'orders', 'orders.sells', 'orders.sells.company', 'orders.sells.product', 'companies', 'area', 'products', 'total_shipment_tonnage'])->where('status', 'a');

      $limit = $req->pageSize ? $req->pageSize : 10;
      $skip = ( $req->pageSize * $req->page ) ? ( $req->pageSize * $req->page ) : 0;

      /**
      * Aryo Pradipta Gema 9 March 2017
      * If the user asks for a target contract or actual contract, they will need to specify it in the request label
      **/

      if($req->label) $contracts = $contracts->where('label', $req->label);
      if($req->startDate) $contracts = $contracts->where('date_from', '>=', $req->startDate);
      if($req->endDate) $contracts = $contracts->where('date_to', '<=', $req->endDate);

      if($req->area_id)
      {
       $area = $req->area_id;
       $contracts = $contracts->where(function($q) use ($area) {
         $q->whereHas('orders.sells.company', function($q) use ($area)
         {
           $q->where('area_id', $area);
         })->orWhere('area_id', $area);
       });
      }

      if($req->company_id)
      {
       $contracts = $contracts->whereHas('orders.sells.company',function($q) use ($req)
       {
         $q->whereRaw('company_id  = '.$req->company_id);
       })->orWhere('company_id',$req->company_id);
      }

      if($req->contract)
      {
      $contracts = $contracts->where('label',$req->contract);
      }

      if($req->unscheduled)
      {
        $contracts = $contracts->has('shipments', '<', '1');
      }

      if($req->legacy) {
        if($req->legacy==='yes') {
          $contracts = $contracts->where('order_id','=',NULL);
        }
        else if($req->legacy==='no') {
          $contracts = $contracts->where('order_id','!=',NULL);
        }
      }

      if($req->q)
      {
       $param = $req->q;
       $contracts = $contracts->where(function($query) use ($param){
         return $query->WhereHas('orders.sells.company',function($q) use ($param) {
                  $q->where('company_name','LIKE','%'.$param.'%');
                })
                ->orWhereHas('companies', function($q) use ($param) {
                  $q->where('company_name', 'LIKE', '%'.$param.'%');
                })
                ->orWhere('contract_no', 'LIKE', '%'.$param.'%')
                ->orWhere('date_from','LIKE','%'.$param.'%')
                ->orWhere('date_to','LIKE','%'.$param.'%')
                ->orWhere('date_to','LIKE','%'.$param.'%');

       });
      }

      $contracts = $contracts->orderBy('contract_no')->skip($skip)->take($limit)->get();
      return response()->json($contracts, 200);
    }

    private function add_date($givendate,$hr=0,$day=0,$mth=0,$yr=0) {
      $cd = strtotime($givendate);
      $newdate = date('Y-m-d h:i:s', mktime(date('h',$cd)+$hr,date('i',$cd), date('s',$cd), date('m',$cd)+$mth,date('d',$cd)+$day, date('Y',$cd)+$yr));
      return $newdate;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if($request->bulk == true)
        if($request->type == 'csv')
          return $this->importCsv($request);

      date_default_timezone_set('Asia/Jakarta');
      if($request->order_id) {
        $order = Order::where('status', 'a')->find($request->order_id);
        if($order){
          // $date_from = $this->add_date($request->date_from, $day`=1);
          // $date_to = $this->add_date($request->date_to, $day=1);`
          // $date_from = new DateTime($request->date_from);
          // $date_to = new DateTime($request->date_to);
          // $date_from = date_add($date_from,date_interval_create_from_date_string("1 days"));
          // $date_to = date_add($date_to,date_interval_create_from_date_string("1 days"));
          // $date_from = new Carbon($request->date_from, 'Asia/Jakarta');
          // $date_to = new Carbon($request->date_to, 'Asia/Jakarta');
          $contract = new Contract();

          $contract->contract_no = $request->contract_no;
          $contract->order_id = $request->order_id;
          $contract->area_id = $request->area_id;
          $contract->shipment_count = $request->shipment_count;
          $contract->term = $request->term;
          $contract->term_desc = $request->term_desc;
          $contract->date_from = $request->date_from;
          $contract->date_to = $request->date_to;
          $contract->currency = $request->currency;
          $contract->label = $request->label ? $request->label : 'a';

          if($request->label && $request->label == 't') {
            $contract->company_id = $request->company_id;
            $contract->product_id = $request->product_id;
            $contract->tonnage = $request->tonnage;
            $contract->price = $request->price;
          }
          $contract->status = 'a';

          $contract->save();

          $order->status = 'f';

          $order->save();

          return $this->show($contract->id);
        }
        else return response()->json(['message'=>'not found'], 404);
      }
      else {
        $contract = new Contract();

        $contract->contract_no = $request->contract_no;
        $contract->order_id = $request->order_id ? $request->order_id : null;
        $contract->area_id = $request->area_id;
        $contract->shipment_count = $request->shipment_count;
        $contract->term = $request->term;
        $contract->term_desc = $request->term_desc;
        $contract->date_from = $request->date_from;
        $contract->date_to = $request->date_to;
        $contract->currency = $request->currency;
        $contract->label = $request->label;
        $contract->company_id = $request->company_id;
        $contract->product_id = $request->product_id;
        $contract->tonnage = $request->tonnage;
        $contract->price = $request->price;
        $contract->status = 'a';

        $contract->save();

        return $this->show($contract->id);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $contract = Contract::with(['shipments' => function($q) {
       $q->where('status', '!=', 'x');
      }, 'shipment_plans', 'shipment_plans.products', 'orders', 'orders.sells', 'orders.sells.company', 'orders.sells.product', 'companies', 'area'])->find($id);

      return response()->json($contract, 200);
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
      $contract = Contract::with('shipments', 'orders', 'orders.buys', 'orders.buys.company', 'orders.buys.product', 'orders.sells', 'orders.sells.company', 'orders.sells.product')->find($id);

      if(!$contract) {
        return response()->json(['message' => 'not found'], 404);
      }
      else {
        $contract->contract_no = $request->contract_no ? $request->contract_no : $contract->contract_no;
        $contract->order_id = $request->order_id ? $request->order_id : $contract->order_id;
        $contract->area_id = $request->area_id ? $request->area_id : $contract->area_id;
        $contract->shipment_count = $request->shipment_count ? $request->shipment_count : $contract->shipment_count;
        $contract->term = $request->term ? $request->term : $contract->term;
        $contract->term_desc = $request->term_desc ? $request->term_desc : $contract->term_desc;
        $contract->date_from = $request->date_from ? $request->date_from : $contract->date_from;
        $contract->date_to = $request->date_to ? $request->date_to : $contract->date_to;
        $contract->label = $request->label ? $request->label : $contract->label;
        $contract->currency = $request->currency ? $request->currency : $contract->currency;
        if($request->label && $request->label == 't') {
          $contract->company_id = $request->company_id ? $request->company_id : $contract->company_id;
          $contract->tonnage = $request->tonnage ? $request->tonnage : $contract->tonnage;
          $contract->price = $request->price ? $request->price : $contract->price;
        }
        if($request->target_id) {
          $contract->target()->attach($request->target_id);
        }
        $contract->status = $request->status ? $request->status : 'a';

        $contract->save();

        // return response()->json($contract, 200);
        return $this->show($contract->id);
      }
    }

    // Theo : not need
    // public function getContractById($id){
    //   $contract = Contract::with('contracts', 'contracts.laycan_start', 'contract.laycan_end', )

    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract = Contract::find($id);

        if(!$contract) {
          return response()->json(['message' => 'not found'], 404);
        }
        else {
          $contract->status = 'x';

          $contract->save();

          return response()->json($contract, 200);
        }
    }

    public function importCsv($req){
      if($req->save)
      {
        if ($req->hasFile('file')) {
          $path = $req->file->getRealPath();

          $csv = array_map('str_getcsv', file($path));
          $attribut = explode(';', $csv[0][0]);
          for ($i=1; $i < count($csv); $i++) {
            $rows[] = explode(';', $csv[$i][0]);
          }

          foreach ($rows as $index=>$row) {
            $company = Company::where('company_name',$row[1])->first();
            if(!$company){
              $company = new Company();
              $company->user_id = Auth::user()->id;
              $company->company_name = $row[1];
              $company->company_type = 'c';
              $company->status = 'a';
              $company->save();
            }

            $product = Product::where('product_name',$row[9])->where('typical_quality',$row[10])->first();
            if(!$product){
              $product = new Product();
              $product->user_id = Auth::user()->id;
              $product->company_id = $company->id;
              $product->product_name = $row[9];
              $product->typical_quality = $row[10];
              $product->status = 'a';
              $product->save();
            }

            //check error and converting date format
            if ($row[0] === null) $error[$index][0]=true;
            if ($row[1] === null) $error[$index][1]=true;
            if (!is_numeric($row[2])||$row[2] === null) $error[$index][2]=true;
            if (!is_numeric($row[3])||$row[3] === null) $error[$index][3]=true;
            if (!is_numeric($row[4])||$row[4] === null) $error[$index][4]=true;
            if ($row[5] === null) $error[$index][5]=true;
            if ($row[6] === null) $error[$index][6]=true;
            $row[7] = date_create_from_format('d/m/Y', $row[7]);
            $row[7] = date_format($row[7],'Y-m-d');
            $row[8] = date_create_from_format('d/m/Y', $row[8]);
            $row[8] = date_format($row[8],'Y-m-d');
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$row[7])||$row[7] === null) $error[$index][7]=true;
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$row[8])||$row[8] === null) $error[$index][8]=true;
            if ($row[9] === null) $error[$index][9]=true;
            if ($row[10] === null) $error[$index][10]=true;

            $insert[] = [
              'area_id' => $company->area_id,
              'contract_no' => $row[0],
              'company_id' => $company->id,
              'product_id' => $product->id,
              'tonnage' => $row[2],
              'price' => $row[3],
              'shipment_count' => $row[4],
              'term' => $row[5],
              'term_desc' => $row[6],
              'date_from' => $row[7],
              'date_to' => $row[8],
              'label' => 'a',
              'status' => 'a'
            ];
          }

          // return response()->json($insert, 200);

          if(!empty($error)) return response()->json(['rows'=>$rows, 'error'=>$error], 200);
          if(!empty($insert)) $con = DB::table('contracts')->insert($insert);
        }
      }
      else{
        if ($req->hasFile('file')) {
          $path = $req->file->getRealPath();

          $csv = array_map('str_getcsv', file($path));
          $attribut = explode(';', $csv[0][0]);
          for ($i=1; $i < count($csv); $i++) {
            $rows[] = explode(';', $csv[$i][0]);
          }

          foreach ($rows as $index=>$row) {
            $company = Company::where('company_name',$row[1])->first();
            if(!$company){
              $company = new Company();
              $company->user_id = Auth::user()->id;
              $company->company_name = $row[1];
              $company->company_type = 'c';
              $company->status = 'a';
              $company->save();
            }

            $product = Product::where('product_name',$row[9])->where('typical_quality',$row[10])->first();
            if(!$product){
              $product = new Product();
              $product->user_id = Auth::user()->id;
              $product->company_id = $company->id;
              $product->product_name = $row[9];
              $product->typical_quality = $row[10];
              $product->status = 'a';
              $product->save();
            }

            //check error and converting date format
            if ($row[0] === null) $error[$index][0]=true;
            if ($row[1] === null) $error[$index][1]=true;
            if (!is_numeric($row[2])||$row[2] === null) $error[$index][2]=true;
            if (!is_numeric($row[3])||$row[3] === null) $error[$index][3]=true;
            if (!is_numeric($row[4])||$row[4] === null) $error[$index][4]=true;
            if ($row[5] === null) $error[$index][5]=true;
            if ($row[6] === null) $error[$index][6]=true;
            $row[7] = date_create_from_format('d/m/Y', $row[7]);
            $row[7] = date_format($row[7],'Y-m-d');
            $row[8] = date_create_from_format('d/m/Y', $row[8]);
            $row[8] = date_format($row[8],'Y-m-d');
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$row[7])||$row[7] === null) $error[$index][7]=true;
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$row[8])||$row[8] === null) $error[$index][8]=true;
            if ($row[9] === null) $error[$index][9]=true;
            if ($row[10] === null) $error[$index][10]=true;

            $insert[] = [
              'area_id' => $company->area_id,
              'contract_no' => $row[0],
              'company_id' => $company->id,
              'product_id' => $product->id,
              'tonnage' => $row[2],
              'price' => $row[3],
              'shipment_count' => $row[4],
              'term' => $row[5],
              'term_desc' => $row[6],
              'date_from' => $row[7],
              'date_to' => $row[8],
              'label' => 'a',
              'status' => 'a'
            ];
          }

          // return response()->json($insert, 200);

          if(!empty($error)) return response()->json(['rows'=>$rows, 'error'=>$error], 200);

        }
      }

      return response()->json(['rows'=>$rows], 200);
    }

    public function contractCalculations(Request $req,$id){
      $contract = Contract::with('contract_calculations','qualities.qualityDetail.qualityMetric')->find($id);
      $formula = $contract->contract_calculations;

      if($formula) {
        $formulaPrice = $formula->price_calculation;
        $formulaTonnage = $formula->tonnage_calculation;


        $j=0;
        foreach ($contract->qualities as $quality) {
          $i=0;
          $detail = [];
          foreach ($quality->qualityDetail as $q_detail) {
            $point=1;
            foreach ($formulaPrice as $fp) {
              if($q_detail->quality_metrics_id===$fp['quality_metric_id']) {
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
            $contract->qualities[$j]->formulaPrice=$detail;
            $j++;
          }

        }

        $j=0;
        foreach ($contract->qualities as $quality) {
          $i=0;
          $detail = [];
          foreach ($quality->qualityDetail as $q_detail) {
            $point=1;
            foreach ($formulaTonnage as $ft) {
              if($q_detail->quality_metrics_id===$ft['quality_metric_id']) {
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
            $contract->qualities[$j]->formulaTonnage=$detail;
            $j++;
          }

        }


      }
      else {
        return $contract->qualities;
        $j=0;
        foreach ($contract->qualities as $quality) {
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



      return response()->json($contract, 200);

    }

    public function getExample(){
      //$path = storage_path('contract.csv');

      // $column[] = array(
      //   "Contract number" => "a3",
      //   "Company name" => "TIGER ENERGY",
      //   "tonnage / volume" => "300",
      //   "price (can be null/empty)" => "10",
      //   "number of shipment" => "30",
      //   "term" => "spot",
      //   "term description" => "tes des",
      //   "shipment date from" => "27/02/2016",
      //   "shipment date to" => "27/03/2016",
      //   "product" => ""
      // );

      // $column = array("Contract number","Company name","tonnage / volume","price (can be null/empty)","number of shipment","term","term description","shipment date from","shipment date to","product");
      // $data1 = array("a3","TIGER ENERGY","300","10","30","spot","tes des","27/02/2016","27/03/2016","");
      // $data2 = array("a4","Birne","30","15","3","spot","tes des","02/02/2016","27/05/2016","");

      $data = array(
        array("Contract number","Company name","tonnage / volume","price (can be null/empty)","number of shipment","term","term description","shipment date from","shipment date to","product"),
        array("a3","TIGER ENERGY","300","10","30","spot","tes des","27/02/2016","27/03/2016",""),
        array("a4","Birne","30","15","3","spot","tes des","02/02/2016","27/05/2016","")
      );

      return Excel::create('contract', function($excel) use ($data) {
        $excel->sheet('sheet 1', function($sheet) use ($data) {
          $sheet->fromArray($data, null, 'A1', false, false);
        });
      })->download('csv');

      //return response()->download($path);
    }
}
