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
    public function index()
    {
        $leads = new \Illuminate\Database\Eloquent\Collection();

        $leads->add(Buyer::where('status', 'a')->get() , Seller::where('status', 'a')->get() , Vendor::where('status', 'a')->get() , Contact::where('status', 'a')->get());

        return response()->json($leads, 200);
    }
}
