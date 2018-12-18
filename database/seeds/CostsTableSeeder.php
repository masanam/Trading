<?php

use Illuminate\Database\Seeder;

use App\Model\CalculationType;
use App\Model\CostSection;
use App\Model\CostHeader;
use App\Model\CostDetail;
use App\Model\Equation;
use App\Model\ConstantSetting;

class CostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	CalculationType::create([	 
        	'id' => 1,
        	'cost_type' => 'Investment Cost'
        ]) ;

        CalculationType::create([    
            'id' => 2,
            'cost_type' => 'Cost of Good Sold'
        ]) ;

        CostSection::create([	 
        	'id' => 1,
        	'section_name' => 'Pre Operating Cost',
            'calculation_id' => 1
        ]) ;

        CostSection::create([    
            'id' => 2,
            'section_name' => 'Infrastructure Cost',
            'calculation_id' => 1
        ]) ;

        CostSection::create([    
            'id' => 3,
            'section_name' => 'Equipment Cost',
            'calculation_id' => 1
        ]) ;

        CostSection::create([    
            'id' => 4,
            'section_name' => 'Production Costs',
            'calculation_id' => 2
        ]) ;

        CostSection::create([    
            'id' => 5,
            'section_name' => 'Fee and Royalty',
            'calculation_id' => 2
        ]) ;

        CostSection::create([    
            'id' => 6,
            'section_name' => 'General & Administration Expenses',
            'calculation_id' => 2
        ]) ;

        CostHeader::create([     
            'id' => 1,
            'calculation_id' => 1,
            'mining_license_id' => 1,
            'date_of_analysis' => '2017-07-09',
            'profit_sharing' => 100,
            'base_currency_id' => 'USD',
            'deal_currency_id'=> 'IDR',
            'exchange_rate' =>13500
        ]) ;

        CostHeader::create([     
            'id' => 2,
            'calculation_id' => 1,
            'mining_license_id' => 2,
            'date_of_analysis' => '2017-09-10',
            'profit_sharing' => 100,
            'base_currency_id' => 'USD',
            'deal_currency_id'=> 'IDR',
            'exchange_rate' =>13500
        ]) ;

        CostHeader::create([     
            'id' => 3,
            'calculation_id' => 1,
            'mining_license_id' => 3,
            'date_of_analysis' => '2017-01-06',
            'profit_sharing' => 100,
            'base_currency_id' => 'USD',
            'deal_currency_id'=> 'IDR',
            'exchange_rate' =>13500
        ]) ;

        CostHeader::create([     
            'id' => 4,
            'calculation_id' => 2,
            'mining_license_id' => 1,
            'date_of_analysis' => '2017-03-04',
            'profit_sharing' => 100,
            'base_currency_id' => 'USD',
            'deal_currency_id'=> 'IDR',
            'exchange_rate' =>13500
        ]) ;

        CostHeader::create([     
            'id' => 5,
            'calculation_id' => 2,
            'mining_license_id' => 2,
            'date_of_analysis' => '2017-07-08',
            'profit_sharing' => 100,
            'base_currency_id' => 'USD',
            'deal_currency_id'=> 'IDR',
            'exchange_rate' =>13500
        ]) ;

        CostHeader::create([     
            'id' => 6,
            'calculation_id' => 2,
            'mining_license_id' => 3,
            'date_of_analysis' => '2017-01-05',
            'profit_sharing' => 100,
            'base_currency_id' => 'USD',
            'deal_currency_id'=> 'IDR',
            'exchange_rate' =>13500
        ]) ;

        CostDetail::create([                 
            'id' => 1,
        	'section_id' => 1,
        	'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Preliminary Geological Survey',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 2,
            'section_id' => 1,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Due Diligence-technical',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 3,
            'section_id' => 1,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Consultant Fee (NRM, RA)',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 4,
            'section_id' => 1,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Legal & Permit',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 5,
            'section_id' => 2,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Acquisition Costs (incl. tax)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 6,
            'section_id' => 2,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Land Acquisition & Clearing',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 7,
            'section_id' => 2,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Haul Road Construction',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 8,
            'section_id' => 2,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Washing Plant',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 9,
            'section_id' => 2,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Stockpile & Facility (ROM)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 10,
            'section_id' => 2,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Bridge',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 11,
            'section_id' => 2,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Port Facility (jetty, crusher, conveyor, etc)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 12,
            'section_id' => 2,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Camp & Office',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 13,
            'section_id' => 3,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Production Equipment',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 14,
            'section_id' => 3,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Non-Production Equipment',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 15,
            'section_id' => 3,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Fixtures & Furnitures',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 16,
            'section_id' => 3,
            'header_id' => 1,
            'user_id' => 1,
            'desc' => 'Pre-Operation Preparation Cost',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 17,
            'section_id' => 1,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Preliminary Geological Survey',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 18,
            'section_id' => 1,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Due Diligence-technical',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 19,
            'section_id' => 1,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Consultant Fee (NRM, RA)',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 20,
            'section_id' => 1,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Legal & Permit',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 21,
            'section_id' => 2,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Acquisition Costs (incl. tax)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 22,
            'section_id' => 2,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Land Acquisition & Clearing',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 23,
            'section_id' => 2,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Haul Road Construction',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 24,
            'section_id' => 2,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Washing Plant',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 25,
            'section_id' => 2,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Stockpile & Facility (ROM)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 26,
            'section_id' => 2,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Bridge',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 27,
            'section_id' => 2,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Port Facility (jetty, crusher, conveyor, etc)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 28,
            'section_id' => 2,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Camp & Office',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 29,
            'section_id' => 3,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Production Equipment',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 30,
            'section_id' => 3,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Non-Production Equipment',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 31,
            'section_id' => 3,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Fixtures & Furnitures',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 32,
            'section_id' => 3,
            'header_id' => 2,
            'user_id' => 1,
            'desc' => 'Pre-Operation Preparation Cost',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 33,
            'section_id' => 1,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Preliminary Geological Survey',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 34,
            'section_id' => 1,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Due Diligence-technical',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 35,
            'section_id' => 1,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Consultant Fee (NRM, RA)',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 36,
            'section_id' => 1,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Legal & Permit',
            'base_value' => 12,
            'deal_value' => 162000,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 37,
            'section_id' => 2,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Acquisition Costs (incl. tax)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 38,
            'section_id' => 2,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Land Acquisition & Clearing',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 39,
            'section_id' => 2,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Haul Road Construction',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 40,
            'section_id' => 2,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Washing Plant',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 41,
            'section_id' => 2,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Stockpile & Facility (ROM)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 42,
            'section_id' => 2,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Bridge',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 43,
            'section_id' => 2,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Port Facility (jetty, crusher, conveyor, etc)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 44,
            'section_id' => 2,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Camp & Office',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 45,
            'section_id' => 3,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Production Equipment',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 46,
            'section_id' => 3,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Non-Production Equipment',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 47,
            'section_id' => 3,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Fixtures & Furnitures',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 48,
            'section_id' => 3,
            'header_id' => 3,
            'user_id' => 1,
            'desc' => 'Pre-Operation Preparation Cost',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 2,
            'status' => 'a'
        ]);




        CostDetail::create([                 
            'id' => 49,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Overburden Removal',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 50,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Blasting',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 51,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Coal Getting',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 52,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Coal Hauling to ROM',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 53,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Stockpile Management',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 54,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Coal Processing (crushing plant)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 55,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Coal Hauling to Port',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 56,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Road Maintenance',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 57,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Port Rehandling & Barge Loading',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 58,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Barging & Stevedoring',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 59,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Surveyor & coal lab analysis',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 60,
            'section_id' => 4,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Environment & Rehabilitation',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 61,
            'section_id' => 5,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Government Royalty',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 62,
            'section_id' => 5,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Land Fee (if any)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 63,
            'section_id' => 5,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Road Fee (APB)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 64,
            'section_id' => 5,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Dana Taktis',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 65,
            'section_id' => 5,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Community Fee / Community Development',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 66,
            'section_id' => 5,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Local Government Income (SP3)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 67,
            'section_id' => 5,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Management Fee',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 68,
            'section_id' => 5,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Other & Interest',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);        

        CostDetail::create([ 
            'id' => 69,
            'section_id' => 6,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Overhead & Other G&A Cost',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([ 
            'id' => 70,
            'section_id' => 6,
            'header_id' => 4,
            'user_id' => 1,
            'desc' => 'Amortization & Depreciation Cost',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 71,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Overburden Removal',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 72,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Blasting',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 73,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Coal Getting',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 74,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Coal Hauling to ROM',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 75,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Stockpile Management',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 76,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Coal Processing (crushing plant)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 77,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Coal Hauling to Port',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 78,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Road Maintenance',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 79,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Port Rehandling & Barge Loading',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 80,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Barging & Stevedoring',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 81,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Surveyor & coal lab analysis',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 82,
            'section_id' => 4,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Environment & Rehabilitation',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 83,
            'section_id' => 5,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Government Royalty',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 84,
            'section_id' => 5,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Land Fee (if any)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 85,
            'section_id' => 5,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Road Fee (APB)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 86,
            'section_id' => 5,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Dana Taktis',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 87,
            'section_id' => 5,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Community Fee / Community Development',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 88,
            'section_id' => 5,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Local Government Income (SP3)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 89,
            'section_id' => 5,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Management Fee',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 90,
            'section_id' => 5,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Other & Interest',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);        

        CostDetail::create([ 
            'id' => 91,
            'section_id' => 6,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Overhead & Other G&A Cost',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([ 
            'id' => 92,
            'section_id' => 6,
            'header_id' => 5,
            'user_id' => 1,
            'desc' => 'Amortization & Depreciation Cost',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 93,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Overburden Removal',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 94,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Blasting',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 95,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Coal Getting',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 96,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Coal Hauling to ROM',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 97,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Stockpile Management',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 98,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Coal Processing (crushing plant)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 99,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Coal Hauling to Port',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 100,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Road Maintenance',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 101,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Port Rehandling & Barge Loading',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 102,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Barging & Stevedoring',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 103,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Surveyor & coal lab analysis',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 104,
            'section_id' => 4,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Environment & Rehabilitation',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 105,
            'section_id' => 5,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Government Royalty',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 106,
            'section_id' => 5,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Land Fee (if any)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 107,
            'section_id' => 5,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Road Fee (APB)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 108,
            'section_id' => 5,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Dana Taktis',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 109,
            'section_id' => 5,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Community Fee / Community Development',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 110,
            'section_id' => 5,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Local Government Income (SP3)',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 111,
            'section_id' => 5,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Management Fee',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([                 
            'id' => 112,
            'section_id' => 5,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Other & Interest',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);        

        CostDetail::create([ 
            'id' => 113,
            'section_id' => 6,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Overhead & Other G&A Cost',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        CostDetail::create([ 
            'id' => 114,
            'section_id' => 6,
            'header_id' => 6,
            'user_id' => 1,
            'desc' => 'Amortization & Depreciation Cost',
            'base_value' => 13,
            'deal_value' => 175500,
            'quantity' => 1,
            'status' => 'a'
        ]);

        Equation::create([	 
        	'id' => 1,
        	'equation_name' => 'Equation Name 1',
        	'equation_desc' => 'Equation Desc 1',
        	'equation' => 'Equation 1'
        ]) ;


        ConstantSetting::create([	 
        	'id' => 1,
        	'constant_name' => 'PPN',
        	'constant_value' => 10,
            'used_in' => 'CoGS',
            'date' => '2017-02-12',
            'status' => 'h'
        ]) ;

        ConstantSetting::create([    
            'id' => 2,
            'constant_name' => 'Profit Sharing',
            'constant_value' => 35,
            'used_in' => 'Investment Cost',
            'date' => '2017-03-12',
            'status' => 'h'
        ]) ;

        ConstantSetting::create([    
            'id' => 3,
            'constant_name' => 'Barging 10 ft',
            'constant_value' => 5,
            'used_in' => 'Investment Cost',
            'date' => '2017-03-11',
            'status' => 'h'
        ]) ;

        ConstantSetting::create([    
            'id' => 4,
            'constant_name' => 'Discount Fee',
            'constant_value' => 10,
            'used_in' => 'Investment Cost',
            'date' => '2017-02-10',
            'status' => 'h'
        ]) ;

        ConstantSetting::create([    
            'id' => 5,
            'constant_name' => 'PPN',
            'constant_value' => 10,
            'used_in' => 'CoGS',
            'date' => '2017-02-12',
            'status' => 'h'
        ]) ;

        ConstantSetting::create([    
            'id' => 6,
            'constant_name' => 'Profit Sharing',
            'constant_value' => 35,
            'used_in' => 'Investment Cost',
            'date' => '2017-03-12',
            'status' => 'h'
        ]) ;

        ConstantSetting::create([    
            'id' => 7,
            'constant_name' => 'Barging 10 ft',
            'constant_value' => 5,
            'used_in' => 'Investment Cost',
            'date' => '2017-03-11',
            'status' => 'h'
        ]) ;

        ConstantSetting::create([    
            'id' => 8,
            'constant_name' => 'Discount Fee',
            'constant_value' => 10,
            'used_in' => 'Investment Cost',
            'date' => '2017-02-10',
            'status' => 'h'
        ]) ;

        ConstantSetting::create([    
            'id' => 9,
            'constant_name' => 'PPN',
            'constant_value' => 10,
            'used_in' => 'CoGS',
            'date' => '2017-02-12',
            'status' => 'a'
        ]) ;

        ConstantSetting::create([    
            'id' => 10,
            'constant_name' => 'Profit Sharing',
            'constant_value' => 35,
            'used_in' => 'Investment Cost',
            'date' => '2017-03-12',
            'status' => 'a'
        ]) ;

        ConstantSetting::create([    
            'id' => 11,
            'constant_name' => 'Barging 10 ft',
            'constant_value' => 5,
            'used_in' => 'Investment Cost',
            'date' => '2017-03-11',
            'status' => 'a'
        ]) ;

        ConstantSetting::create([    
            'id' => 12,
            'constant_name' => 'Discount Fee',
            'constant_value' => 10,
            'used_in' => 'Investment Cost',
            'date' => '2017-02-10',
            'status' => 'a'
        ]) ;


    }
}