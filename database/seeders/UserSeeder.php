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
                'username' => 'User',
                'email' => 'user@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'34234234',
                'remember_token'=>"dsdsdsdsd",
                'status'=>'1',
            ]
        ]);
    }
}
