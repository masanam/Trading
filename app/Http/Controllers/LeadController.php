<?php

namespace App\Http\Controllers;

use App\Model\Buyer;
use App\Model\Seller;
use App\Model\Vendor;
use App\Model\Contact;

use Illuminate\Http\Request;

use App\Http\Requests;

class LeadController extends Controller
{
    // public function __construct() {
    //     $this->middleware('jwt.auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($search = false)
    {
        $leads = new \Illuminate\Database\Eloquent\Collection();

        if (!$search) {
	        $buyer = Buyer::where('status', 'a')->get();
	        $seller = Seller::where('status', 'a')->get();
	        $vendor = Vendor::where('status', 'a')->get();
	        $contact = Contact::where('status', 'a')->get();
        } else {
        	$buyer = Buyer::where('status', 'a')->where('company_name', 'LIKE', '%'.$search.'%')->get();
	        $seller = Seller::where('status', 'a')->where('company_name', 'LIKE', '%'.$search.'%')->get();
	        $vendor = Vendor::where('status', 'a')->where('company_name', 'LIKE', '%'.$search.'%')->get();
	        $contact = Contact::where('status', 'a')->where('name', 'LIKE', '%'.$search.'%')->get();
        }
        
        foreach($buyer as $b) {
            $b['type'] = 'buyer';
            $leads->add($b);
        }

        foreach($seller as $s) {
            $s['type'] = 'seller';
            $leads->add($s);
        }

        foreach($vendor as $v) {
            $v['type'] = 'vendor';
            $leads->add($v);
        }

        foreach($contact as $c) {
            $c['type'] = 'contact';
            $leads->add($c);
        }

        $leads = $leads->sortBy('order_date');

        return response()->json(['success' => TRUE, $leads], 200);
    }
}
