<?php

use Illuminate\Database\Seeder;
use App\Model\ProductPrice;
use App\Model\Settings;



class ProductPricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductPrice::create(['product_id' => 1,
            'date' =>'2016-11-30',
            'barging'=>'20',
            'discount'=>'20',
            'price'=>'400',
            'status'=>'a'
        ]);

        ProductPrice::create(['product_id' => 1,
            'date' =>'2017-11-30',
            'barging'=>'20',
            'discount'=>'20',
            'price'=>'205',
            'status'=>'a'
        ]);

        ProductPrice::create(['product_id' => 2,
            'date' =>'2016-11-30',
            'barging'=>'20',
            'discount'=>'20',
            'price'=>'146',
            'status'=>'a'
        ]);

        ProductPrice::create(['product_id' => 2,
            'date' =>'2017-11-30',
            'barging'=>'20',
            'discount'=>'20',
            'price'=>'200',
            'status'=>'a'
        ]);

        ProductPrice::create(['product_id' => 3,
            'date' =>'2017-11-30',
            'barging'=>'20',
            'discount'=>'20',
            'price'=>'203',
            'status'=>'a'
        ]);

        ProductPrice::create(['product_id' => 4,
            'date' =>'2017-11-30',
            'barging'=>'20',
            'discount'=>'20',
            'price'=>'205',
            'status'=>'a'
        ]);

        ProductPrice::create(['product_id' => 5,
            'date' =>'2016-11-30',
            'barging'=>'20',
            'discount'=>'20',
            'price'=>'200',
            'status'=>'a'
        ]);

        ProductPrice::create(['product_id' => 5,
            'date' =>'2017-11-30',
            'barging'=>'20',
            'discount'=>'20',
            'price'=>'212',
            'status'=>'a'
        ]);

        ProductPrice::create(['product_id' => 6,
            'date' =>'2017-11-30',
            'barging'=>'20',
            'discount'=>'20',
            'price'=>'198',
            'status'=>'a'
        ]);


        Settings::create(['application' => 'coalbizpedia',
            'variable' =>'NEWCASTLE',
            'value' =>'3',
        ]);

    }
}
