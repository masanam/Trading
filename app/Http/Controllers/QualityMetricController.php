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
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Events\InputEditCoalpedia;

class QualityMetricController extends Controller
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
    return response()->json($quality_metrics, 200);
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
}
