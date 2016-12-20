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
            // [ 'name' => 'Fuganto Widjaja', 'email' => 'fuganto@gmail.com', 'title' => 'CEO', 'image' => 'http://www.thesundaytimes.co.uk/sto/multimedia/dynamic/01143/01_B19ARM_1143800k.jpg', 'phone'=> '1234567890', 'role'=>'manager', 'manager_id'=>null],
            // [ 'name' => 'Bonifasius Huang', 'email' => 'bonifasius.huang@sinarmasmining.com', 'title' => 'Acting CEO', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'manager', 'manager_id'=>null],
            // [ 'name' => 'Dwi Suseno', 'email' => 'dwi.suseno@sinarmasmining.com', 'title' => 'Trading Head', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'manager', 'manager_id'=>2],
            // [ 'name' => 'Lely Indahsari', 'email' => 'lelyindahsari@borneo-indobara.com', 'title' => 'Trading Head', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'manager', 'manager_id'=>2],
            // [ 'name' => 'Giovanny Sientoro', 'email' => 'giovanny.sientoro@borneo-indobara.com', 'title' => 'Supervisor', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'manager', 'manager_id'=>3],
            // [ 'name' => 'Denise Lestari', 'email' => 'deny.lestari@sinarmasmining.com', 'title' => 'Supervisor', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'manager', 'manager_id'=>3],
            // [ 'name' => 'Yos Wibowo', 'email' => 'yos.wibowo@sinarmasmining.com', 'title' => 'Supervisor', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'manager', 'manager_id'=>3],
            // [ 'name' => 'Prasetyo Nugraha Gema', 'email' => 'pras@volantech.io', 'title' => 'Admin', 'image' => 'https://media.licdn.com/mpr/mpr/shrinknp_200_200/AAEAAQAAAAAAAAJcAAAAJDVlZTYyMzE0LTBkYWMtNDM3My05NzA1LTYyNmI1OGExMjVkNg.jpg', 'phone'=> '1234567890', 'role'=>'admin', 'manager_id'=>null],
            // [ 'name' => 'Martin', 'email' => 'martin@volantech.io', 'title' => 'Admin', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'admin', 'manager_id'=>null],
            // [ 'name' => 'Anton Damayanto', 'email' => 'anton.damayanto@sinarmasmining.com', 'title' => 'Supervisor', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'manager', 'manager_id'=>3],
            // [ 'name' => 'Nattasya', 'email' => 'nattasya.nattasya@borneo-indobara.com', 'title' => 'Supervisor', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'manager', 'manager_id'=>3],
            // [ 'name' => 'Herlina', 'email' => 'herlina.herlina@borneo-indobara.com', 'title' => 'Supervisor', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'manager', 'manager_id'=>4],
            // [ 'name' => 'Atta ', 'email' => 'atta.domajuwono@sinarmasmining.com', 'title' => 'Trader', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'trader', 'manager_id'=>6],
            // [ 'name' => 'Gian Hariyanto', 'email' => 'gian.haryanto@sinarmasmining.com', 'title' => 'Trader', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'trader', 'manager_id'=>6],
            // [ 'name' => 'Dona da Silva', 'email' => 'dona.dasilva@sinarmasmining.com', 'title' => 'Trader', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'trader', 'manager_id'=>7],
            // [ 'name' => 'Flora Anggraeni', 'email' => 'flora.anggraini@sinarmasmining.com', 'title' => 'Trader', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'trader', 'manager_id'=>7],
            // [ 'name' => 'Denny Tarigan', 'email' => 'denny.tarigan@sinarmasmining.com', 'title' => 'Trader', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'trader', 'manager_id'=>10],
            // [ 'name' => 'Surya Wahana', 'email' => 'surya.wahana@sinarmasmining.com', 'title' => 'Trader', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'trader', 'manager_id'=>5],
            // [ 'name' => 'Edy Suwarno', 'email' => 'edy.suwarno@sinarmasmining.com', 'title' => 'Trader', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'trader', 'manager_id'=>5],
            // [ 'name' => 'Vina Pratiwi', 'email' => 'vina.pratiwi@sinarmasmining.com', 'title' => 'Trader', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'trader', 'manager_id'=>11],
            // [ 'name' => 'Rano', 'email' => 'rano.permana@sinarmasmining.com', 'title' => 'MDP', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'user', 'manager_id'=>6],
            // [ 'name' => 'Hilla', 'email' => 'hilla.sholihah@sinarmasmining.com', 'title' => 'MDP', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'user', 'manager_id'=>7],
            // [ 'name' => 'Fahmi Andrian', 'email' => 'fahmi.andrian@sinarmasmining.com', 'title' => 'MDP', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'user', 'manager_id'=>12],

            [ 'name' => 'Prasetyo Nugraha Gema', 'email' => 'pras@volantech.io', 'title' => 'Admin', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'admin', 'manager_id'=>null],
            [ 'name' => 'Martin', 'email' => 'dev@volantech.io', 'title' => 'Admin', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'admin', 'manager_id'=>1],
            [ 'name' => 'Giovanny Sientoro', 'email' => 'giovanny.sientoro@borneo-indobara.com', 'title' => 'Supervisor', 'image' => './images/default.png', 'phone'=> '1234567890', 'role'=>'manager', 'manager_id'=>3],
        ];


        foreach($users as $user){
            User::create([
                'name' => $user['name'],
                'title' => $user['title'],
                'image' => $user['image'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'password' => bcrypt('secret'),
                'role' => $user['role'],
                'status' => 'a' 
            ]);
        }
    }
}
