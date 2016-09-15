<?php

use App\Model\User;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'Fuganto Widjaja',
            'title' => 'CEO GEMS',
            'image' => 'http://www.thesundaytimes.co.uk/sto/multimedia/dynamic/01143/01_B19ARM_1143800k.jpg',
            'email' => 'fu@gems.com',
            'phone' => '+62811111111',
            'password' => bcrypt('secret'),
            'role' => 'trader',
            'status' => 'a'
        ]);

        User::create([
            'id' => 2,
            'name' => 'Mochtar Suhadi',
            'title' => 'Director GEMS',
            'image' => 'https://media.licdn.com/mpr/mpr/shrinknp_200_200/AAEAAQAAAAAAAALiAAAAJGY3ZmI2MTExLWExMDQtNDNkOS05MzBiLWI1MzBhMjkzMmE5OQ.jpg',
            'email' => 'mosu@gems.com',
            'phone' => '+62811111112',
            'password' => bcrypt('secret'),
            'role' => 'trader',
            'status' => 'a'
        ]);

        User::create([
            'id' => 3,
            'name' => 'Albert C Santos',
            'title' => 'CTO GEMS',
            'image' => 'https://media.licdn.com/mpr/mpr/shrinknp_200_200/p/1/000/035/32e/01ac9be.jpg',
            'email' => 'albertsantos@gems.com',
            'phone' => '+62811111113',
            'password' => bcrypt('secret'),
            'role' => 'trader',
            'status' => 'a'
        ]);

        User::create([
            'id' => 4,
            'name' => 'Prasetyo Nugraha Gema',             
            'title' => 'Admin Coal Trade',
            'image' => 'https://media.licdn.com/mpr/mpr/shrinknp_200_200/AAEAAQAAAAAAAAJcAAAAJDVlZTYyMzE0LTBkYWMtNDM3My05NzA1LTYyNmI1OGExMjVkNg.jpg',
            'email' => 'pras@volantech.io',
            'phone' => '+62811111234',
            'password' => bcrypt('secret'),
            'role' => 'admin',
            'status' => 'a'
        ]);

        User::create([
            'id' => 5,
            'name' => 'Buyer',         
            'title' => 'CEO Jaya Shakti Barutama',
            'image' => './img/default.png',
            'email' => 'buyer@buyer.com',
            'phone' => '+62811123456',
            'password' => bcrypt('secret'),
            'role' => 'user',
            'status' => 'a'
        ]);

        User::create([
            'id' => 6,
            'name' => 'Seller',         
            'title' => 'CEO Kuansing Inti Makmur',
            'image' => './img/default.png',
            'email' => 'seller@seller.com',
            'phone' => '+62811123456',
            'password' => bcrypt('secret'),
            'role' => 'user',
            'status' => 'a'
        ]);
    }
}
