<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Template;

use App\Http\Requests;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $template = Template::all();
      return response()->json($template, 200);
    }
}
