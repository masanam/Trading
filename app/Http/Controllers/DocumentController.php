<?php

namespace App\Http\Controllers;

use App\Model\Shipment;
use App\Model\Document;
use App\Model\Template;
use App\Model\DocumentDetail;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

// Document Controller
// Created by Myrtyl
// 06/02/2017

class DocumentController extends Controller
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
        /*
         * Myrtyl 06/02/2017
         */

        if(!$req->status) $status = ['a', 'o'];
        else $status = [$req->status];

        $document = Document::whereIn('status', $status);

        if($req->template_id) $document->where('template_id', $req->template_id);
        if($req->shipment_id) $document->where('shipment_id', $req->shipment_id);

        $document->orderBy('created_at', 'DESC');
        $document->orderBy('version', 'DESC');

        return response()->json($document->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        // Get Previous Versions
        $previous = Document::where('shipment_id', $req->shipment_id)
            ->where('template_id', $req->template_id)
            ->where('status', 'a')
            ->first();

        if($previous){
            $prev_id = $previous->id;
            $prev_version = $previous->version;
        }

        // Add id of previous version to this new order, version is added 1 from the previous ones
        $document = new Document();

        $document->title = $req->title;
        $document->remarks = $req->remarks;
        $document->shipment_id = $req->shipment_id;
        $document->template_id = $req->template_id;
        $document->user_id = Auth::user()->id;
        $document->older_version = $prev_id;
        $document->status = 'a';
        $document->version = $prev_version+1;

        $document->save();

        if($previous){
            $previous->newer_version = $document->id;
            $previous->status = 'o';
            $previous->save();
        }

        foreach($req->document_details as $d){
            $detail = new DocumentDetail();

            $detail->document_id = $document->id;
            $detail->field = $d['field'];
            $detail->content = $d['content'];

            $detail->save();
        }

        // save the id of this new version to the next version of current document

        return $this->show($document->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Document::with(['template', 'shipment', 'shipment.customer', 'user', 'documentDetails'])->find($id);
        return $document;
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
        $document = Document::find($id);

        $req->shipment_id = $document->shipment_id;
        $req->template_id = $document->template_id;

        $this->store($req);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = Document::find($id);

        if(!$document) {
          return response()->json(['message' => 'not found'], 404);
        }
        else {
          $document->status = 'x';

          $document->save();

          return response()->json($document, 200);
        }
    }
}
