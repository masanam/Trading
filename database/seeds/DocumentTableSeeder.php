<?php

use Illuminate\Database\Seeder;

use App\Model\Document;
use App\Model\DocumentDetail;
use App\Model\Template;

class DocumentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Template::create([
          'id' => 1,
          'template_name' => 'RO',
          'desc' => 'Royalty',
          'category' => 'pre',
          'sequence' => 1,
          'fields' => json_decode('[
                {
                    "key":"ntpn",
                    "type":"input",
                    "templateOptions": {
                        "type":"text",
                        "label":"NTPN",
                        "placeholder":"NTPN"
                    }
                },
                {
                    "key":"payment_date",
                    "type":"datepicker",
                    "templateOptions": {
                        "type":"date",
                        "label":"Payment Date",
                        "placeholder":"Payment Date"
                    }
                }
            ]'),
          'status' => 'a'
        ]) ;
        Template::create([
          'id' => 2,
          'template_name' => 'LC',
          'desc' => 'Letter of Credit',
          'category' => 'pre',
          'sequence' => 2,
          'fields' => json_decode('[
                {
                    "key":"bank",
                    "type":"input",
                    "templateOptions": {
                        "type":"text",
                        "label":"Issuing Bank",
                        "placeholder":"Enter doc2"
                    }
                },
                {
                    "key":"advise",
                    "type":"input",
                    "templateOptions": {
                        "type":"text",
                        "label":"Advising Bank",
                        "placeholder":"Advising Bank"
                    }
                },
                {
                    "key":"lc_type",
                    "type":"select",
                    "templateOptions": {
                        "label":"LC Type",
                        "options": [
                            {
                                "name": "LC SIGHT",
                                "value": "LC SIGHT"
                            },
                            {
                                "name": "LC USANCE",
                                "value": "LC USANCE"
                            },
                            {
                                "name": "LC UPAS",
                                "value": "LC UPAS"
                            }
                        ]
                    }
                },
                {
                    "key":"issue_date",
                    "type":"datepicker",
                    "templateOptions": {
                        "type":"date",
                        "label":"Issuing Date",
                        "placeholder":"Issuing Date"
                    }
                },
                {
                    "key":"expiry_date",
                    "type":"datepicker",
                    "templateOptions": {
                        "type":"date",
                        "label":"Expiry Date",
                        "placeholder":"Expiry Date"
                    }
                },
                {
                    "key":"applicant",
                    "type":"input",
                    "templateOptions": {
                        "type":"text",
                        "label":"Applicant",
                        "placeholder":"Applicant"
                    }
                },
                {
                    "key":"lc_amount",
                    "type":"input",
                    "templateOptions": {
                        "type":"number",
                        "label":"LC Amount (Days)",
                        "placeholder":"LC Amount (Days)"
                    }
                },
                {
                    "key":"amount_tolerence",
                    "type":"input",
                    "templateOptions": {
                        "type":"number",
                        "step":"0.01",
                        "label":"LC Amount (%)",
                        "placeholder":"LC Amount (%)"
                    }
                },
                {
                    "key":"latest_shipment",
                    "type":"datepicker",
                    "templateOptions": {
                        "type":"date",
                        "label":"Latest Shipment Date",
                        "placeholder":"Latest Shipment Date"
                    }
                },
                {
                    "key":"lc_presentation",
                    "type":"input",
                    "templateOptions": {
                        "type":"number",
                        "label":"LC Presentation (Days)",
                        "placeholder":"LC Presentation (Days)"
                    }
                },
                {
                    "key":"lc_type_remarks",
                    "type":"input",
                    "templateOptions": {
                        "type":"text",
                        "label":"Remarks",
                        "placeholder":"Remarks"
                    }
                }
                ]'),
          'status' => 'a'
        ]) ;

        // Template::create([
        //     'id' => 3,
        //     'template_name' => 'SI',
        //     'desc' => 'Shipping Instruction',
        //     'category' => 'pre',
        //     'sequence' => 3,
        //     'fields' => json_decode('[
        //         {
        //             "key":"no",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"No",
        //                 "placeholder":"No"
        //             }
        //         },
        //         {
        //             "key":"date",
        //             "type":"datepicker",
        //             "templateOptions": {
        //                 "type":"date",
        //                 "label":"Date",
        //                 "placeholder":"Date"
        //             }
        //         },
        //         {
        //             "key":"to",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"To",
        //                 "placeholder":"To"
        //             }
        //         },
        //         {
        //             "key":"shipper",
        //             "type":"textarea",
        //             "templateOptions": {
        //                 "type":"textarea",
        //                 "label":"Shipper",
        //                 "placeholder":"Shipper"
        //             }
        //         },
        //         {
        //             "key":"consignee",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Consignee",
        //                 "placeholder":"Consignee"
        //             }
        //         },
        //         {
        //             "key":"notify_party",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Notify Party",
        //                 "placeholder":"Notify Party"
        //             }
        //         },
        //         {
        //             "key":"loading_port",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Port of Loading",
        //                 "placeholder":"Port of Loading"
        //             }
        //         },
        //         {
        //             "key":"destination_port",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Port of Destination",
        //                 "placeholder":"Port of Destination"
        //             }
        //         },
        //         {
        //             "key":"goods_description",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Description of Goods",
        //                 "placeholder":"Description of Goods"
        //             }
        //         },
        //         {
        //             "key":"loadable_quantity",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Loadable Quantity (MT)",
        //                 "placeholder":"Loadable Quantity (MT)"
        //             }
        //         },
        //         {
        //             "key":"loadable_quantity_tolerance",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Loadable Quantity Tolerance (%)",
        //                 "placeholder":"Loadable Quantity Tolerance (%)"
        //             }
        //         },
        //         {
        //             "key":"witness",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Witness",
        //                 "placeholder":"Witness"
        //             }
        //         },
        //         {
        //             "key":"documents_berau_redeb",
        //             "type":"textarea",
        //             "templateOptions": {
        //                 "type":"textarea",
        //                 "label":"PT Berau Coal - Tg Redeb Documents",
        //                 "placeholder":"PT Berau Coal - Tg Redeb Documents"
        //             }
        //         },
        //         {
        //             "key":"documents_shipping_agent",
        //             "type":"textarea",
        //             "templateOptions": {
        //                 "type":"textarea",
        //                 "label":"Shipping Agent Documents",
        //                 "placeholder":"Shipping Agent Documents"
        //             }
        //         },
        //         {
        //             "key":"documents_surveyor",
        //             "type":"textarea",
        //             "templateOptions": {
        //                 "type":"textarea",
        //                 "label":"Surveyor Documents",
        //                 "placeholder":"Surveyor Documents"
        //             }
        //         },
        //         {
        //             "key":"analysis_method",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Analysis Method",
        //                 "placeholder":"Analysis Method"
        //             }
        //         },
        //         {
        //             "key":"buyer_sample_size",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Buyers\' Sample Size",
        //                 "placeholder":"Buyers\' Sample Size"
        //             }
        //         },
        //         {
        //             "key":"buyer_sample_weight",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Buyers\' Sample Weight",
        //                 "placeholder":"Buyers\' Sample Weight"
        //             }
        //         },
        //         {
        //             "key":"buyer_sample_address",
        //             "type":"input",
        //             "templateOptions": {
        //                 "type":"text",
        //                 "label":"Buyers\' Sample Address",
        //                 "placeholder":"Buyers\' Sample Address"
        //             }
        //         }
        //
        //     ]'),
        //     'status' => 'a'
        // ]);

        Template::create([
            'id' => 3,
            'template_name' => 'BL',
            'desc' => 'BL',
            'category' => 'post',
            'sequence' => 1,
            'fields' => json_decode('[
              {
                "key":"scan_copy_date",
                "type":"datepicker",
                "templateOptions":
                {
                  "type":"date",
                  "label":"Scan Copy Date",
                  "placeholder":"Scan Copy Date"
                }
              },
              {
                "key":"hard_copy_date",
                "type":"datepicker",
                "templateOptions":
                {
                  "type":"date",
                  "label":"Hard Copy Date",
                  "placeholder":"Hard Copy Date"
                }
              },
              {
                "key":"number_of_bl",
                "type":"input",
                "templateOptions":
                {
                  "type":"text",
                  "label":"Number Of BL",
                  "placeholder":"Number Of BL"
                }
              },
              {
                "key":"remarks",
                "type":"input",
                "templateOptions":
                {
                  "type":"text",
                  "label":"Remarks",
                  "placeholder":"Remarks"
                }
              }
              ]'),
            'status' => 'a'
        ]) ;
        Template::create([
            'id' => 4,
            'template_name' => 'Surveyor Certif',
            'desc' => 'Surveyor Certif',
            'category' => 'post',
            'sequence' => 2,
            'fields' => json_decode('[
              {
                "key":"actual_quality",
                "type":"input",
                "templateOptions":
                {
                  "type":"text",
                  "label":"Actual Quality",
                  "placeholder":"Actual Quality"
                }
              },
              {
                "key":"scan_copy_date",
                "type":"datepicker",
                "templateOptions":
                {
                  "type":"date",
                  "label":"Scan Copy Date",
                  "placeholder":"Password"
                }
              },
              {
                "key":"hard_copy_date",
                "type":"datepicker",
                "templateOptions":
                {
                  "type":"date",
                  "label":"Hard Copy Date",
                  "placeholder":"Password"
                }
              },
              {
                "key":"remarks",
                "type":"input",
                "templateOptions":
                {
                  "type":"text",
                  "label":"Remarks",
                  "placeholder":"Remarks"
                }
              }
              ]'),
            'status' => 'a'
        ]) ;
        Template::create([
            'id' => 5,
            'template_name' => 'COO Gov',
            'desc' => 'COO Gov',
            'category' => 'post',
            'sequence' => 3,
            'fields' => json_decode('[
              {
                "key": "buyers",
                "type": "repeatSection",
                "templateOptions": {
                  "btnText": "Add another buyer",
                  "fields": [
                    {
                      "className": "row",
                      "fieldGroup": [
                        {
                          "type": "input",
                          "key": "buyer",
                          "templateOptions": {
                            "label": "Buyer",
                            "type":"text"
                          }
                        },
                        {
                          "type": "input",
                          "key": "tonnage",
                          "templateOptions": {
                            "label": "Tonnage",
                            "type":"text"
                          }
                        }
                      ]
                    }
                  ]
                }
              },
              {
                "key":"no_coo",
                "type":"input",
                "templateOptions":
                {
                  "type":"text",
                  "label":"No COO",
                  "placeholder":"No COO"
                }
              },
              {
                "key":"coo_date",
                "type":"datepicker",
                "templateOptions":
                {
                  "type":"date",
                  "label":"COO Date",
                  "placeholder":"COO Date"
                }
              },
              {
                "key":"scan_copy_date",
                "type":"datepicker",
                "templateOptions":
                {
                  "type":"date",
                  "label":"Scan Copy Date",
                  "placeholder":"Scan Copy Date"
                }
              },
              {
                "key":"hard_copy_date",
                "type":"datepicker",
                "templateOptions":
                {
                  "type":"date",
                  "label":"Hard Copy Date",
                  "placeholder":"Hard Copy Date"
                }
              },
              {
                "key":"remarks",
                "type":"input",
                "templateOptions":
                {
                  "type":"text",
                  "label":"Remarks",
                  "placeholder":"Remarks"
                }
              }
              ]'),
            'status' => 'a'
        ]) ;

        Document::create([
          'id' => 1,
          'template_id' => 1,
          'shipment_id' => 1,
          'user_id' => 2,
          'title' => 'Test1',
          'remarks' => 'Testing Documents 1',
          'url' => 'Testing1',
          'older_version' => 1,
          'newer_version' => 10,
          'version' => 10,
          'status' => 'a'
        ]) ;

        Document::create([
          'id' => 2,
          'template_id' => 2,
          'shipment_id' => 2,
          'user_id' => 2,
          'title' => 'Test2',
          'remarks' => 'Testing Documents 2',
          'url' => 'Testing2',
          'older_version' => 2,
          'newer_version' => 20,
          'version' => 20,
          'status' => 'a'
        ]) ;

        Document::create([
            'id' => 3,
            'template_id' => 3,
            'shipment_id' => 3,
            'user_id' => 3,
            'title' => 'Test3',
            'remarks' => 'Testing Documents 3',
            'url' => 'Testing3',
            'older_version' => 3,
            'newer_version' => 30,
            'version' => 30,
            'status' => 'a'
        ]) ;

        Document::create([
            'id' => 4,
            'template_id' => 2,
            'shipment_id' => 3,
            'user_id' => 3,
            'title' => 'Test3',
            'remarks' => 'Testing Documents 2',
            'url' => 'Testing3',
            'older_version' => 3,
            'newer_version' => 30,
            'version' => 30,
            'status' => 'a'
        ]) ;

        Document::create([
            'id' => 5,
            'template_id' => 1,
            'shipment_id' => 3,
            'user_id' => 3,
            'title' => 'Test3',
            'remarks' => 'Testing Documents 1',
            'url' => 'Testing3',
            'older_version' => 3,
            'newer_version' => 30,
            'version' => 30,
            'status' => 'a'
        ]) ;

        Document::create([
            'id' => 6,
            'template_id' => 3,
            'shipment_id' => 2,
            'user_id' => 2,
            'title' => 'Test2',
            'remarks' => 'Testing Documents 3',
            'url' => 'Testing2',
            'older_version' => 2,
            'newer_version' => 20,
            'version' => 20,
            'status' => 'a'
        ]) ;

        Document::create([
            'id' => 7,
            'template_id' => 1,
            'shipment_id' => 2,
            'user_id' => 2,
            'title' => 'Test2',
            'remarks' => 'Testing Documents 1',
            'url' => 'Testing2',
            'older_version' => 2,
            'newer_version' => 20,
            'version' => 20,
            'status' => 'a'
        ]) ;

        Document::create([
            'id' => 8,
            'template_id' => 4,
            'shipment_id' => 1,
            'user_id' => 2,
            'title' => 'Test1',
            'remarks' => 'Testing Documents 1',
            'url' => 'Testing1',
            'older_version' => 1,
            'newer_version' => 10,
            'version' => 10,
            'status' => 'a'
        ]) ;

        Document::create([
            'id' => 9,
            'template_id' => 5,
            'shipment_id' => 2,
            'user_id' => 2,
            'title' => 'Test2',
            'remarks' => 'Testing Documents 2',
            'url' => 'Testing2',
            'older_version' => 2,
            'newer_version' => 20,
            'version' => 20,
            'status' => 'a'
        ]) ;

        // Document::create([
        //     'id' => 10,
        //     'template_id' => 6,
        //     'shipment_id' => 3,
        //     'user_id' => 3,
        //     'title' => 'Test3',
        //     'remarks' => 'Testing Documents 3',
        //     'url' => 'Testing3',
        //     'older_version' => 3,
        //     'newer_version' => 30,
        //     'version' => 30,
        //     'status' => 'a'
        // ]) ;

        Document::create([
            'id' => 10,
            'template_id' => 5,
            'shipment_id' => 3,
            'user_id' => 3,
            'title' => 'Test3',
            'remarks' => 'Testing Documents 2',
            'url' => 'Testing3',
            'older_version' => 3,
            'newer_version' => 30,
            'version' => 30,
            'status' => 'a'
        ]) ;

        Document::create([
            'id' => 11,
            'template_id' => 4,
            'shipment_id' => 3,
            'user_id' => 3,
            'title' => 'Test3',
            'remarks' => 'Testing Documents 1',
            'url' => 'Testing3',
            'older_version' => 3,
            'newer_version' => 30,
            'version' => 30,
            'status' => 'a'
        ]) ;

        // Document::create([
        //     'id' => 13,
        //     'template_id' => 6,
        //     'shipment_id' => 2,
        //     'user_id' => 2,
        //     'title' => 'Test2',
        //     'remarks' => 'Testing Documents 3',
        //     'url' => 'Testing2',
        //     'older_version' => 2,
        //     'newer_version' => 20,
        //     'version' => 20,
        //     'status' => 'a'
        // ]) ;

        Document::create([
            'id' => 12,
            'template_id' => 4,
            'shipment_id' => 2,
            'user_id' => 2,
            'title' => 'Test2',
            'remarks' => 'Testing Documents 1',
            'url' => 'Testing2',
            'older_version' => 2,
            'newer_version' => 20,
            'version' => 20,
            'status' => 'a'
        ]) ;


        DocumentDetail::create([
            'id' => 1,
            'document_id' => 1,
            'field' => 'Doc 1 Field 1',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 2,
            'document_id' => 1,
            'field' => 'Doc 1 Field 2',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 3,
            'document_id' => 1,
            'field' => 'Doc 1 Field 3',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 4,
            'document_id' => 2,
            'field' => 'Doc 2 Field 1',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 5,
            'document_id' => 2,
            'field' => 'Doc 2 Field 2',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 6,
            'document_id' => 2,
            'field' => 'Doc 2 Field 3',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 7,
            'document_id' => 3,
            'field' => 'Doc 3 Field 1',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 8,
            'document_id' => 3,
            'field' => 'Doc 3 Field 2',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 9,
            'document_id' => 3,
            'field' => 'Doc 3 Field 3',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 10,
            'document_id' => 8,
            'field' => 'Doc 1 Field 1',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 11,
            'document_id' => 8,
            'field' => 'Doc 1 Field 2',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 12,
            'document_id' => 8,
            'field' => 'Doc 1 Field 3',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 13,
            'document_id' => 9,
            'field' => 'Doc 2 Field 1',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 14,
            'document_id' => 9,
            'field' => 'Doc 2 Field 2',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 15,
            'document_id' => 9,
            'field' => 'Doc 2 Field 3',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 16,
            'document_id' => 10,
            'field' => 'Doc 3 Field 1',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 17,
            'document_id' => 10,
            'field' => 'Doc 3 Field 2',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;

        DocumentDetail::create([
            'id' => 18,
            'document_id' => 10,
            'field' => 'Doc 3 Field 3',
            'content' => 'Lorem ipsum dolor sit amet, qui in omnis persecuti, delenit inermis has an. Cu nam sumo falli eripuit, tale impetus vim cu, mei tota omittam cu. Et omnesque dissentias eam. No commune prodesset sadipscing eam, esse doctus ea vis, pri utamur feugiat mandamus et. Qui ne legendos molestiae vulputate, quot eros laudem usu ut, vix ut causae latine.'
        ]) ;
    }
}
