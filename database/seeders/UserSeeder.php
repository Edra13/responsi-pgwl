<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // //Create a new user
        // $user = new \App\Models\User();
        // $user->name = 'Admin';
        // $user->phone = '087777777';
        // $user->email = 'admin@gmail.com'; 
        // $user->password = bcrypt('admin123'); 
        // $user->save();  

        // Create a multiple user
        $user = [
            [
                'name' => 'Admin',
                'phone' => '0898765432',
                'email' => 'admin@gmail.com',
                'password' =>  bcrypt('43210'),
            ],
            [
                'name' => 'User',
                'phone' => '084455667788',
                'email' => 'user@gmail.com',
                'password' =>  bcrypt('98765'),
            ],
            ];

            // Insert the user into the database
            DB::table('users')->insert($user);
    }
}
