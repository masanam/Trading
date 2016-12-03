<?php

namespace App\Http\Controllers;

use App\Model\Company;
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
        $buyer = Company::where('status', 'a')->where('company_type', 'b')->count();
        $seller = Company::where('status', 'a')->where('company_type', 's')->count();
        $vendor = Company::where('status', 'a')->where('company_type', 'v')->count();
        $concession = Concession::where('status', 'a')->count();

        return response()->json([
            'buyer' => $buyer,
            'seller' => $seller,
            'vendor' => $vendor,
            'concession' => $concession,
        ], 200);
    }
}
