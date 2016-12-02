<?php

namespace App\Http\Controllers;

use App\Model\Buyer;
use App\Model\Seller;
use App\Model\Vendor;
use App\Model\Concession;

use Illuminate\Http\Request;

use App\Http\Requests;

class CoalpediaController extends Controller
{
    // public function __construct() {
    //     $this->middleware('jwt.auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function count()
    {
        $buyer = Buyer::where('status', 'a')->count();
        $seller = Seller::where('status', 'a')->count();
        $vendor = Vendor::where('status', 'a')->count();
        $concession = Concession::where('status', 'a')->count();

        return response()->json([
            'buyer' => $buyer,
            'seller' => $seller,
            'vendor' => $vendor,
            'concession' => $concession,
        ], 200);
    }
}
