<?php

use App\Model\User;
use App\Model\Role;
use App\Model\Privilege;

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

            [ 'name' => 'Prasetyo Nugraha Gema', 'email' => 'pras@volantech.io', 'title' => 'Admin', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>null],
            [ 'name' => 'Martin', 'email' => 'martin@volantech.io', 'title' => 'Admin', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>1],
            [ 'name' => 'Aryo Pradipta Gema', 'email' => 'aryo@volantech.io', 'title' => 'Admin', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>1],
            [ 'name' => 'Fahmi', 'email' => 'fahmi@volantech.io', 'title' => 'Admin', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>1],
            [ 'name' => 'Giovanny Sientoro', 'email' => 'giovanny.sientoro@borneo-indobara.com', 'title' => 'Supervisor', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>2],
            [ 'name' => 'Yudhi', 'email' => 'yudhi@berau.com', 'title' => 'Scheduler', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>3],
            [ 'name' => 'Rori', 'email' => 'rori@berau.com', 'title' => 'Intel', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>5],
            [ 'name' => 'Andez', 'email' => 'andez@volantech.io', 'title' => 'Supervisor', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>6],
            [ 'name' => 'Kamal', 'email' => 'kamal@volantech.io', 'title' => 'Staff', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>7],
            [ 'name' => 'Sakti', 'email' => 'hasapu@volantech.io', 'title' => 'Staff', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>8],
            [ 'name' => 'Fuganto Widjaja', 'email' => 'fuganto@gmail.com', 'title' => 'CEO', 'image' => './images/default.png', 'phone'=> '1234567890', 'employee_no'=>'EMP-123', 'manager_id'=>null],

        ];


        foreach($users as $user){
            User::create([
                'name' => $user['name'],
                'title' => $user['title'],
                'image' => $user['image'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'manager_id' => $user['manager_id'],
                'password' => bcrypt('secret'),
                'status' => 'a'
            ]);
        }

        // RESERVED ADMIN ROLES
        Role::create(['id' => 1,    'role' => 'root']);
        Role::create(['id' => 2,    'role' => 'admin']);
        Role::create(['id' => 3,    'role' => 'admin-trade']);
        Role::create(['id' => 4,    'role' => 'admin-index']);
        Role::create(['id' => 5,    'role' => 'admin-bd']);
        Role::create(['id' => 6,    'role' => 'admin-scheduler']);
        Role::create(['id' => 7,    'role' => 'admin-docs']);
        Role::create(['id' => 8,    'role' => 'admin-target']);
        Role::create(['id' => 9,    'role' => 'admin-bi']);
        Role::create(['id' => 10,   'role' => 'audit']);

        // GENERIC MANAGER LEVELS
        Role::create(['id' => 11,   'role' => 'executive']);
        Role::create(['id' => 12,   'role' => 'director']);
        Role::create(['id' => 13,   'role' => 'manager']);
        Role::create(['id' => 14,   'role' => 'Supervisor']);

        // GENERIC ARCHETYPE
        Role::create(['id' => 15,   'role' => 'trader']);
		    Role::create(['id' => 16,   'role' => 'intel']);
        Role::create(['id' => 17,   'role' => 'bd']);
		    Role::create(['id' => 18,   'role' => 'scheduler']);
        Role::create(['id' => 19,   'role' => 'sales']);
		    Role::create(['id' => 20,   'role' => 'marketing']);

        // SPECIFIC APPROVAL Berau ROLES
        Role::create(['id' => 21,   'role' => 'cmo']);
        Role::create(['id' => 22,   'role' => 'trade-manager-area-1']);
        Role::create(['id' => 23,   'role' => 'trade-manager-area-2']);
        Role::create(['id' => 24,   'role' => 'trade-manager-area-3']);
        Role::create(['id' => 25,   'role' => 'trade-manager-area-4']);
        Role::create(['id' => 26,   'role' => 'trade-supervisor']);
        Role::create(['id' => 27,   'role' => 'general-manager']);

        // SPECIFIC APPROVAL BIB ROLES
        Role::create(['id' => 28,   'role' => 'sales-manager']);
        Role::create(['id' => 29,   'role' => 'trading-head']);        

        User::find(1)->roles()->attach([1, 2, 11]); // Pras: root, admin, executive
        User::find(11)->roles()->attach(11);
        
        if(config('app.deployment') == 'berau'){
            User::find(2)->roles()->attach(21); // Martin: cmo
            User::find(3)->roles()->attach(21); // Aryo: cmo
            User::find(4)->roles()->attach(21); // Fahmi: cmo
        }
        if(config('app.deployment') == 'bib'){
            User::find(2)->roles()->attach(29); // Martin: cmo
            User::find(3)->roles()->attach(29); // Aryo: cmo
            User::find(4)->roles()->attach(29); // Fahmi: cmo
        }

        if(config('app.deployment') == 'berau'){
          User::find(5)->roles()->attach(27); // Gio: General Manager
          User::find(6)->roles()->attach(27); // Yudhi: General Manager            
        }
        if(config('app.deployment') == 'bib'){
          User::find(5)->roles()->attach(28);
          User::find(6)->roles()->attach(28);
        }
        

        User::find(7)->roles()->attach(22); // Rori: trade-manager-area-1
        User::find(8)->roles()->attach(23); // Andez: trade-manager-area-2
        User::find(9)->roles()->attach(15); // Kamal: trader
        User::find(10)->roles()->attach(15); // Sakti: trader

        Privilege::create([ 'id' => 1, 'menu' => 'order.view' ]);
        Privilege::create([ 'id' => 2, 'menu' => 'order.edit' ]);
        Privilege::create([ 'id' => 3, 'menu' => 'order.approval' ]);
        Privilege::create([ 'id' => 4, 'menu' => 'lead.view' ]);
        Privilege::create([ 'id' => 5, 'menu' => 'lead.edit' ]);
        Privilege::create([ 'id' => 6, 'menu' => 'index.view' ]);
        Privilege::create([ 'id' => 7, 'menu' => 'index.edit' ]);
        Privilege::create([ 'id' => 8, 'menu' => 'coalpedia.view' ]);
        Privilege::create([ 'id' => 9, 'menu' => 'coalpedia.edit' ]);

        Role::find(1)->privileges()->attach(7);
        Role::find(2)->privileges()->attach(7);
        Role::find(11)->privileges()->attach(3); // executive

        Role::find(15)->privileges()->attach(2); // traders
        Role::find(15)->privileges()->attach(5);
        Role::find(15)->privileges()->attach(9);
        

        Role::find(22)->privileges()->attach(3); // trade-manager-area-1

        Role::find(23)->privileges()->attach(3); // trade-manager-area-2

        Role::find(26)->privileges()->attach(3); // trade-supervisor
        Role::find(26)->privileges()->attach(4);
        Role::find(26)->privileges()->attach(6);

        if(config('app.deployment') == 'berau'){
            Role::find(27)->privileges()->attach(3); // 
            Role::find(21)->privileges()->attach(3);
        }
        if(config('app.deployment') == 'bib'){
            Role::find(28)->privileges()->attach(3); // 
            Role::find(29)->privileges()->attach(3);
        }
    }
}
