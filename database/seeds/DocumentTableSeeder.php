<?php

use Illuminate\Database\Seeder;

use App\Model\Document;
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
        	'template_name' => 'Testing Documents1',
        	'desc' => 'Testing Documents1',
        	'category' => 'Testing',
        	'sequence' => 1,
        	'fields' => '[]',
        	'status' => 'a'
        ]) ;Template::create([	 
        	'id' => 2,
        	'template_name' => 'Testing Documents2',
        	'desc' => 'Testing Documents2',
        	'category' => 'Testing',
        	'sequence' => 2,
        	'fields' => '[]',
        	'status' => 'a'
        ]) ;
        
        Document::create([	 
        	'id' => 1,
        	'template_id' => 1,
        	'shipment_id' => 1,
        	'user_id' => 2,
        	'title' => 'Test1',
        	'remarks' => 'Testing Documents1',
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
        	'remarks' => 'Testing Documents2',
        	'url' => 'Testing2',
        	'older_version' => 2,
        	'newer_version' => 20,
        	'version' => 20,
        	'status' => 'a'
        ]) ;
    }
}