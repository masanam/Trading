<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\MiningLicense;
use App\Model\MiningLicenseHistory;
use App\Model\Settings;
use App\Model\IndexPrice;
use Auth;

use App\Http\Requests;
use DB;

class MiningLicenseController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /* Kamal 2017-01-19 18:00
     * create All function CRUD
     */
    public function index(Request $req = null)
    {
        $license = MiningLicense::with(['Company','Contact','checked_by','CostHeader.costDetailSum','CostHeader.calculationType','CostHeader.costTotal','Concession.products.product_price.product']);
        if($req->calculation_id)
          $license->with(['CostHeader' => function($q) use ($req) { $q->where('calculation_id', $req->calculation_id);}]);
        $license->select('id','no','company_id','concession_id','source','contact_id','type','status','checked_by','checked_at','expired','overlap_other','release_after','is_corrupt','is_operating','close_to_sinarmas_factory','close_to_sinarmas_concession','close_to_river','close_to_other_concession','coal_bearing_formation','is_mining_zone','is_settlement_zone','is_palm_plantation','is_farming_zone','is_sinarmas_forestry');
        if($req->draft) $license->whereIn('status',[1, 2, 3]);
        else $license->whereNotIn('status',[1, 2, 3]);

        if($req->calculation_id){
          $license->whereHas('CostHeader', function($q) use ($req) {
            $q->whereRaw('calculation_id = '.$req->calculation_id);
          });
        }

        if($req->q)
          $license->where(function($q) use ($req) {
            $q->whereHas('Company', function($q) use ($req){
               $q->where('company_name','LIKE', '%'.$req->q.'%');
             })->orwhereHas('Contact', function($q) use ($req){
               $q->where('name','LIKE', '%'.$req->q.'%');
             })->orwhereHas('Concession.products.product_price', function($q) use ($req){
               $q->where('price','LIKE', '%'.$req->q.'%');
             })->orwhereHas('CostHeader.costTotal', function($q) use ($req){
               $q->where('cogs','LIKE', '%'.$req->q.'%');
             })
            ->orWhere('no', 'LIKE','%'.$req->q.'%')
            ->orWhere('source', 'LIKE','%'.$req->q.'%')
            ->orWhere('type', 'LIKE','%'.$req->q.'%');
          });

        // if($req->company) {
        //   $company = $req->company;
        //   $license->whereHas('Company', function($q) use ($company){
        //     $q->where('company_name', 'LIKE', '%'.$company.'%');
        //   })->whereHas('CostHeader.costTotal', function($q) use ($req){
        //     $q->whereBetween('cogs', [$req->min,$req->max]);
        //   })
        //   ->where('no',$req->iup);
        // }

        if($req->company) {
          $settings = Settings::where('application',$req->app)->where('variable',$req->variable)->first();
          $indexprice = IndexPrice::where('status','a')->where('index_id',$settings->value)->orderBy('date', 'DESC')->first();
          $indexprice = $indexprice->price;
          $company = $req->company;
          $sign = '';
          $remark = $req->remarks;

          if($remark==='1') $sign = '=';
          elseif ($remark==='2') $sign = '>';
          elseif ($remark==='3') $sign = '<';

          $license->whereHas('Company', function($q) use ($company){
            $q->where('company_name', 'LIKE', '%'.$company.'%');
          })->whereHas('CostHeader.costTotal', function($q) use ($req){
            $q->whereBetween('cogs', [$req->min,$req->max]);
          })->whereHas('Concession.products.product_price', function($q) use ($sign,$indexprice){
            $q->where('price',$sign,$indexprice);
          })
          ->where('no',$req->iup);
        }

        $license = $license->get();
        foreach ($license as $l) {
            if($l->expired > Date('Y-m-d')) $l->filter_expired = 0;
            else $l->filter_expired = 1;
            if(!$l->coal_bearing_formation) $l->filter_coal_bearing = 0;
            else $l->filter_coal_bearing = 1;
            if($l->status == 1 || $l->status == 2 || $l->status == 3) $l->filter_draft = 1;
            else $l->filter_draft = 0;
        }

        if($req->select_iup_invetment_cogs){
          $licenses_id = $license->pluck('id');
          $license = MiningLicense::with('CostHeader.costDetailSum','CostHeader.costTotal','CostHeader.calculationType')->whereNotIn('id',$licenses_id)->get();
        }

        return response()->json($license, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        if(!$req) {
          return response()->json([
            'message' => 'Bad Request'
          ], 400);
        }

        $license = new MiningLicense($req->all());
        $license->created_by = Auth::User()->id;
        if($req->polygon) $license->polygon = DB::raw('GeomFromText(\'POLYGON('.$req->polygon.')\')');
        $license->status = '1';
        $license->save();

        return response()->json($license, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $req = null)
    {
      $license = MiningLicense::with('Company','Contact','Concession.products.product_price','Concession.port','checked_by','MiningLicenseFile','spatial_data','MiningLicenseHistory', 'MiningLicenseHistory.User','CostHeader.costDetail');
      if(!empty($req->calculation_id))
          $license->with(['CostHeader' => function($q) use ($req) { $q->where('calculation_id', $req->calculation_id);}]);
      $license->select('*', DB::raw('ST_AsGeoJSON(polygon, 8) AS polygon'))->where('id',$id);

      if(!empty($req->calculation_id)){
        $license->whereHas('CostHeader', function($q) use ($req) {
          $q->whereRaw('calculation_id = '.$req->calculation_id);
        });
      }

      return response()->json($license->first(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        if(!$req) {
          return response()->json([
            'message' => 'Bad Request'
          ], 400);
        }
        $license = MiningLicense::find($id);
        $license->fill($req->all());
        if($req->status) {
            if($license->status !== 'p') $license->status = $req->status;
            // make reason decline null if status change to pending
            if($license->status === 'p'){
                $license->approval_main_reason = null;
                $license->approval_reason_description = null;
            }else if($license->status === 'd'){
                $license->approval_main_reason = null;
                $license->approval_reason_description = null;
            }
        }
        $license->expired = date('Y-m-d',strtotime($req->expired));
        $license->checked_at = date('Y-m-d',strtotime($req->checked_at));
        if($req->polygon) $license->polygon = DB::raw('GeomFromText(\'POLYGON('.$req->polygon.')\')');

        if($req->overlay){
            $license->spatial_data()->sync($req->overlay);
        }

        $license->save();

        return $this->show($license->id);
    }

    public function approval(Request $req, $id)
    {
      if(!$req) {
        return response()->json([
          'message' => 'Bad Request'
        ], 400);
      }

      $license = MiningLicense::find($id);
      $old_status = $license->status;
      $license ->status = $req->status;
      $license ->approval_main_reason = $req->approval_main_reason;
      $license ->approval_reason_description = $req->approval_reason_description;
      $license->save();
      //hasapu
      $iuphistory = new MiningLicenseHistory();
      $iuphistory->user_id = Auth::User()->id;
      $iuphistory->mining_license_id = $req->id;
      $iuphistory->new_value = $req->status;
      $iuphistory->old_value = $old_status;
      if ($req->description){
        $iuphistory->description = $req->description;
      }

      $iuphistory->save();


      return $this->show($license->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $license = MiningLicense::find($id);

        if (!$license) {
          return response()->json([
            'message' => 'Not found'
          ] ,404);
        }

        $license->status = 'x';
        $license->save();

        return response()->json($license, 200);
    }
}
