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
        $customer = Company::where('status', 'a')->whereIn('company_type', ['c', 't'])->count();
        $supplier = Company::where('status', 'a')->whereIn('company_type', ['s', 't'])->count();
        $vendor = Company::where('status', 'a')->where('company_type', 'v')->count();
        $concession = Concession::where('status', 'a')->count();

        return response()->json([
            'customer' => $customer,
            'supplier' => $supplier,
            'vendor' => $vendor,
            'concession' => $concession,
        ], 200);
    }
}
