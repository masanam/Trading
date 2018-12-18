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
    public function index(){
      $templates = Template::all();
      return response()->json($templates, 200);
    }

    public function show($id){
      $template = Template::find($id);
      return response()->json($template, 200);
    }

    public function update(Request $req, $id){
      $template = Template::find($id);

      if (!$req) {
        return response()->json([
          'message' => 'Bad Request'
        ], 400);
      }

      if (!$template) {
        return response()->json([
          'message' => 'template Not found'
        ] ,404);
      }

      if($req->status) {
        $template->status = $req->status;
      }

      $template->fill($req->all());
      $template->save();

      return response()->json($template, 200);
    }

    public function store(Request $req){
      $template = new Template($req->all());

      if (!$req) {
        return response()->json([
          'message' => 'Bad Request'
        ], 400);
      }

      $template->save();

      return response()->json($template, 200);
    }
}
