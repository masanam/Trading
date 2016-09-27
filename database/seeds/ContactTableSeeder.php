<?php

use App\Model\Contact;
use Illuminate\Database\Seeder;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::create([
          'id' => 1,
          'name' => 'Fuganto Widjaja',
          'buyer_id' => 1,
          'seller_id' => 0,
          'user_id' => 1,
          'email' => 'fu@gems.com',
          'phone' => '+62811111111',
          'status' => 'a'
        ]);
    }
}
