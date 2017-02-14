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
        	'template_name' => 'Testing Documents 1',
        	'desc' => 'Testing Documents 1',
        	'category' => 'Testing',
        	'sequence' => 1,
        	'fields' => '[]',
        	'status' => 'a'
        ]) ;
        Template::create([	 
        	'id' => 2,
        	'template_name' => 'Testing Documents 2',
        	'desc' => 'Testing Documents 2',
        	'category' => 'Testing',
        	'sequence' => 2,
        	'fields' => '[]',
        	'status' => 'a'
        ]) ;
        Template::create([   
            'id' => 3,
            'template_name' => 'Testing Documents 3',
            'desc' => 'Testing Documents 3',
            'category' => 'Testing',
            'sequence' => 3,
            'fields' => '[

            ]',
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
    }
}