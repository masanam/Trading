<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Model\User;
use App\Model\LoginUser;
use App\Model\Lead;
use App\Model\Order;
use App\Model\OrderUser;
use App\Model\IndexPrice;
use App\Model\Index;
use App\Model\OrderNegotiation;
use App\Model\OrderApprovalLog;
use App\Model\OrderApprovalScheme;
use App\Model\OrderApprovalSchemeSequence;
use App\Model\Contract;
use App\Model\Role;
use App\Model\Company;
use App\Model\Product;

use Tymon\JWTAuth\Facades\JWTAuth;
use Ixudra\Curl\Facades\Curl;
use Firebase\FirebaseInterface;
use Firebase\FirebaseLib;
use Auth;
use Excel;

use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalRequest;

class DownloadController extends Controller
{
  public function __construct(Order $order)
  {
    $this->middleware('jwt.auth', [ 'except' => 'approval' ]);
    $this->order = $order;
  }


  public function downloadCsvOrder(Request $req)
  {
    $orders = Order::with([
        'approvals' => function ($query){
          $query->orderBy('created_at')->where('order_approvals.status', 'a')->groupBy('order_id');
        }, 'index_price',
        'totalSellVolume', 'averageSellPrice', 'sells.company', 'index',
        'earliestSellLaycan', 'latestSellLaycan', 'trader','users'
      ]);

    if($req->startDate) $orders = $orders->where('created_at', '>=', $req->startDate);
    if($req->endDate) $orders = $orders->where('created_at', '<=', $req->endDate);

    // $totalUser = User::where('status', 'a')->count();
    // $totalLogin = LoginUser::count();


    $totalLogin = LoginUser::count();
    $totalUser = User::where('status', 'a')->count();
    $totalOrder = Order::count();
    $totalLead = Lead::count();
    $totalCompany = Company::count();
    $totalProduct = Product::count();

    $user_activities = DB::table('login_user')
            ->select('users.id','users.name', 'users.email', 'users.phone', 'login_user.num_login')
            ->rightJoin('users', 'users.id', '=', 'login_user.user_id')
            ->get();

    // $user_activities = LoginUser::with('User')->get()->toArray();
    // dd($user_leads->toSql());
    // dd($user_activities);
    // dd($user_activities->toSql());

    $act = [];
    foreach ($user_activities as $u) {
      $user_lead = DB::table('leads')
            ->where('user_id', $u->id)
            ->count();
      $user_order = DB::table('orders')
            ->where('user_id', $u->id)
            ->count();
      $user_company = DB::table('companies')
            ->where('user_id', $u->id)
            ->count();
      $user_product = DB::table('products')
            ->where('user_id', $u->id)
            ->count();
      if($u->num_login==null){
        $u->num_login = '0';
        $user_lead = '0';
        $user_order = '0';
        $user_company ='0';
        $user_product ='0';
      }else{
        if($user_lead==0) $user_lead='0';
        if($user_order==0) $user_order='0';
        if($user_company==0) $user_company='0';
        if($user_product==0) $user_product='0';
      }
      $act[] = array(
          "name" => $u->name,
          "email"=> $u->email,
          "phone"=> $u->phone,
          "num_login" => $u->num_login,
          "num_lead" => $user_lead,
          "num_order" => $user_order,
          "num_company" => $user_company,
          "num_product" => $user_product
      );
    }
    $orders = $orders->get();//->toArray();
    $ord = [];
    $totalPending = 0;
    $totalAccept = 0;
    $totalInShipment = 0;
    $totalDraft = 0;
    $totalCombined = 0;
    $totalCancel = 0;
    foreach ($orders as $o) {
      $nol = '';
      for ($i=3; $i >=strlen($o->trader['id']) ; $i--) {
        $nol .='0';
      }
      if($o->index_name){
        $index_name = $o->index_name;
        $index_provider = $o->index_provider;
        $price = $o->price;
      }else{
        $index_name = $o->index['index_name'];
        $index_provider = $o->index['index_provider'];
        if($o->index_price!=NULL){
          foreach ($o->index_price as $i) {
            $price = $i['price'];
          }
        }else{
          $price = 'N/A';
        }
      }
      if($o->status=="p"){
        $status = "Pending";
        $totalPending++;
      }
      if($o->status=="a"){
        $status = "Approved";
        $totalAccept++;
      }
      if($o->status=="f"){
        $status = "In Shipment";
        $totalInShipment++;
      }
      if($o->status=="d"){
        $status = "Draft";
        $totalDraft++;
      }
      if($o->status=="c"){
        $status = "Combined";
        $totalCombined++;
      }
      if($o->status=="x"){
        $status = "Cancel";
        $totalCancel++;
      }

      foreach ($o->totalSellVolume as $tonage) {
        $volume = $tonage['volume'];
      }
      foreach ($o->averageSellPrice as $average) {
        $avgPrice = $average['price'];
      }

      $customer = '';
      $product_name = '';
      $n = count($o->sells);
      $init = 0;
      foreach ($o->sells as $sell) {
        if($init == $n-1){
          $customer .= $sell->company['company_name'];
          $product_name .= $sell->product_name;
        }else{
          $customer .= $sell->company['company_name'].', ';
          $product_name .= $sell->product_name.', ';
        }
        $base_currency = $sell->pivot['base_currency_id'];
        $init ++;
      }


      foreach ($o->earliestSellLaycan as $laycan_start) {
        $startDate = date('d M y',strtotime($laycan_start['laycan_start']));
        $price = $o->index_price['price'];
        // foreach ($o->index_price as $i) {
        //   $price = $i['price'];
        // }
        // $price = $o->index_price[0];
      }

      foreach ($o->latestSellLaycan as $laycan_end) {
        $endDate = date('d M y',strtotime($laycan_end['laycan_end']));
      }

      foreach ($o->approvals as $approvals) {
        $arr = explode(' ',trim($approvals->name));
        $approval_name = $arr[0];
        $updated_at = $approvals->updated_at->format('d M y');
      }
      if($o->in_house==1){
        $in_house = 'Yes';
      }else{
        $in_house = 'No';
      }
      if($o->approval_sequence==0){
        $o->approval_sequence = '0';
      }
      $ord[] = array(
        "Order No" => "ORD#".$nol.$o->trader['id'],
        "Email" => $o->trader['email'],
        "In House" => $in_house,
        "Index Name" => $index_name,
        "Index Provider" => $index_provider,
        "Price Index" => $price,
        "Tonnage" => $volume,
        "Base Currency" => $base_currency,
        "Base Price" => $avgPrice,
        "Customer" => $customer,
        "Product" => $product_name,
        "L/D" => $startDate.' ~ '.$endDate,
        "Last Approval" => $approval_name.', '.$updated_at,
        "Approval Sequence" => $o->approval_sequence,
        "Cancellation Reason" => $o->cancel_reason,
        "Request Reason" => $o->request_reason,
        "Finalize Reason" => $o->finalize_reason,
        "Status" => $status,
        "Created At" => $o->created_at->format('d M y'),
        "Updated At" => $o->updated_at->format('d M y')
      );
    }
    // dd($statusOrder['status']);

    return Excel::create('order_csv_download', function($excel) use ($ord, $totalUser, $totalLogin, $totalOrder, $totalLead, $totalCompany, $totalProduct, $act, $totalDraft, $totalPending, $totalInShipment, $totalCombined, $totalAccept, $totalCancel) {
      $excel->sheet('order_report', function($sheet) use ($ord, $totalDraft, $totalPending, $totalInShipment, $totalCombined, $totalAccept, $totalCancel) {
        $sheet->rows([
          $sheet->fromArray($ord),
          [''],
          ['Total Draft', $totalDraft],
          ['Total Pending', $totalPending],
          ['Total In Shipment', $totalInShipment],
          //['Total Combined', $totalCombined],
          ['Total Accept', $totalAccept],
          ['Total Cancel', $totalCancel],
        ]);
      });
      $excel->sheet('user_activity_report', function($sheet) use ($totalUser, $totalLogin, $totalOrder, $totalLead, $totalCompany, $totalProduct, $act, $totalDraft, $totalPending, $totalInShipment, $totalCombined, $totalAccept, $totalCancel) {
        $sheet->rows([
          $sheet->fromArray($act),
          [''],
          ['Total User',$totalUser],
          ['Total Login',$totalLogin],
          ['Total Order',$totalOrder],
          ['Total Lead',$totalLead],
          ['Total Company',$totalCompany],
          ['Total Product',$totalProduct]
        ]);
      });
      // $excel->sheet('order_activity_report', function($sheet) use ($orders) {
      //   $sheet->fromArray($orders);
      // });
    })->download('xls');
  }
}
