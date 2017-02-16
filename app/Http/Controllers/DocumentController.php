<?php

namespace App\Http\Controllers;

use App\Model\Shipment;
use App\Model\Document;
use App\Model\Template;
use App\Model\DocumentDetail;

use Illuminate\Http\Request;

use App\Http\Requests;

// Document Controller
// Created by Myrtyl
// 06/02/2017

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
         * Myrtyl 06/02/2017
         */
        $document = Document::all()->where('status', 'a');
        return response()->json($document, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        return $req->all();
        // $document = new Document();
        // $document->template_id = $req->template_id;
        // $document->shipment_id = $req->shipment_id;
        // $document->user_id = $req->user_id;
        // // $document->user_id = Auth::User()->id;
        // $document->title = $req->title;
        // $document->remarks = $req->remarks;
        // $document->status = 'a';

        // $document->save();

        // foreach ($document_detail as $document_details) {
        //     $document_detail = new DocumentDetails();
        //     $document_detail->document_id = 'document.id';
        //     $document_detail->field = $req->field;
        //     $document_detail->content = $req->content;

        //     $document->save();
        // }        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Document::with(['documentDetails'])->find($id);
        return $document;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
