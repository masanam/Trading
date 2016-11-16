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
        $users = [
            [
                'id' => 1,
                'name' => 'Fuganto Widjaja',
                'title' => 'CEO GEMS',
                'image' => 'http://www.thesundaytimes.co.uk/sto/multimedia/dynamic/01143/01_B19ARM_1143800k.jpg',
                'email' => 'fuganto.widjaja@goldenenergymines.com',
                'phone' => '+62811111111',
                'password' => bcrypt('secret'),
                'role' => 'manager',
                'manager_id' => null,
                'status' => 'a'
            ],
            [
                'id' => 2,
                'name' => 'Mochtar Suhadi',
                'title' => 'Acting CEO',
                'image' => 'https://media.licdn.com/mpr/mpr/shrinknp_200_200/AAEAAQAAAAAAAALiAAAAJGY3ZmI2MTExLWExMDQtNDNkOS05MzBiLWI1MzBhMjkzMmE5OQ.jpg',
                'email' => 'mochtar.suhadi@goldenenergymines.com',
                'phone' => '+62811111112',
                'password' => bcrypt('secret'),
                'role' => 'manager',
                'manager_id' => 1,
                'status' => 'a'
            ],
            [
                'id' => 3,
                'name' => 'Lely Indahsari',
                'title' => 'Trading Head',
                'image' => './images/default.png',
                'email' => 'lelyindahsari@borneo-indobara.com',
                'phone' => '+62811111113',
                'password' => bcrypt('secret'),
                'role' => 'manager',
                'manager_id' => 2,
                'status' => 'a'
            ],
            [
                'id' => 4,
                'name' => 'Giovanny Sientoro',             
                'title' => 'Manager',
                'image' => './images/default.png',
                'email' => 'giovanny.sientoro@borneo-indobara.com',
                'phone' => '+62811111234',
                'password' => bcrypt('secret'),
                'role' => 'manager',
                'manager_id' => 3,
                'status' => 'a'
            ],
            [
                'id' => 5,
                'name' => 'Denny Nugroho',             
                'title' => 'Trader',
                'image' => './images/default.png',
                'email' => 'denny.nugroho@sinarmasmining.com',
                'phone' => '+62811111234',
                'password' => bcrypt('secret'),
                'role' => 'manager',
                'manager_id' => 3,
                'status' => 'a'
            ],
            [
                'id' => 6,
                'name' => 'Nattasya',             
                'title' => 'Trader',
                'image' => './images/default.png',
                'email' => 'nattasya.nattasya@borneo-indobara.com',
                'phone' => '+62811111234',
                'password' => bcrypt('secret'),
                'role' => 'manager',
                'manager_id' => 3,
                'status' => 'a'
            ],
            [
                'id' => 7,
                'name' => 'Herlina',             
                'title' => 'Trader',
                'image' => './images/default.png',
                'email' => 'herlina.herlina@borneo-indobara.com',
                'phone' => '+62811111234',
                'password' => bcrypt('secret'),
                'role' => 'manager',
                'manager_id' => 3,
                'status' => 'a'
            ],
            [
                'id' => 8,
                'name' => 'Prasetyo Nugraha Gema',             
                'title' => 'Admin Coal Trade',
                'image' => 'https://media.licdn.com/mpr/mpr/shrinknp_200_200/AAEAAQAAAAAAAAJcAAAAJDVlZTYyMzE0LTBkYWMtNDM3My05NzA1LTYyNmI1OGExMjVkNg.jpg',
                'email' => 'pras@volantech.io',
                'phone' => '+628112200333',
                'password' => bcrypt('secret'),
                'role' => 'admin',
                'manager_id' => null,
                'status' => 'a'
            ]
        ];

        foreach($users as $user){
            User::create([
                'id' => $user['id'],
                'name' => $user['name'],
                'title' => $user['title'],
                'image' => $user['image'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'password' => $user['password'],
                'role' => $user['role'],
                'status' => $user['status'] 
            ]);
        }
    }
}
