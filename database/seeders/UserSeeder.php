<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'username' => 'Thinh',
                'email' => 'thinh@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356798543',
                'token'=>"dsdsdsdsd",
                'remember_token'=>"dsdsdsdsd",
                'status'=>'1',
            ],
            [
                'username' => 'Duc',
                'email' => 'duc@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356155456',
                'token'=>"dsdsdsdsd2",
                'remember_token'=>"dsdsdsdsd2",
                'status'=>'1',
            ]
        ]);
    }
}
