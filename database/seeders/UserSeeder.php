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
            ],
            [
                'username' => 'XuanThinh',
                'email' => 'xuannnthinh@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356798586',
                'token'=>"dsdsdsdsd",
                'remember_token'=>"dsdsdsdsd",
                'status'=>'1',
            ],
            [
                'username' => 'Ducduc',
                'email' => 'ducđucuc@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356155087',
                'token'=>"dsdsdsdsd2",
                'remember_token'=>"dsdsdsdsd2",
                'status'=>'1',
            ],
            [
                'username' => 'Hoang',
                'email' => 'hoang@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356790987',
                'token'=>"dsdsdsdsd",
                'remember_token'=>"dsdsdsdsd",
                'status'=>'1',
            ],
            [
                'username' => 'nhan',
                'email' => 'nhan@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356159090',
                'token'=>"dsdsdsdsd2",
                'remember_token'=>"dsdsdsdsd2",
                'status'=>'1',
            ],
            [
                'username' => 'khang',
                'email' => 'khang@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356798524',
                'token'=>"dsdsdsdsd",
                'remember_token'=>"dsdsdsdsd",
                'status'=>'1',
            ],
            [
                'username' => 'duy',
                'email' => 'duy@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356155402',
                'token'=>"dsdsdsdsd2",
                'remember_token'=>"dsdsdsdsd2",
                'status'=>'1',
            ],
            [
                'username' => 'thuan',
                'email' => 'thuan@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356798048',
                'token'=>"dsdsdsdsd",
                'remember_token'=>"dsdsdsdsd",
                'status'=>'1',
            ],
            [
                'username' => 'hieu',
                'email' => 'hieu123@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356155907',
                'token'=>"dsdsdsdsd2",
                'remember_token'=>"dsdsdsdsd2",
                'status'=>'1',
            ],
            [
                'username' => 'dat',
                'email' => 'dat@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356798345',
                'token'=>"dsdsdsdsd",
                'remember_token'=>"dsdsdsdsd",
                'status'=>'1',
            ],
            [
                'username' => 'quoc',
                'email' => 'quoc@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356155859',
                'token'=>"dsdsdsdsd2",
                'remember_token'=>"dsdsdsdsd2",
                'status'=>'1',
            ],
            [
                'username' => 'tai',
                'email' => 'tai@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356798456',
                'token'=>"dsdsdsdsd",
                'remember_token'=>"dsdsdsdsd",
                'status'=>'1',
            ],
            [
                'username' => 'nghia',
                'email' => 'nghia@gmail.com',
                'password' => bcrypt('admin123'),
                'phone_number'=>'0356155234',
                'token'=>"dsdsdsdsd2",
                'remember_token'=>"dsdsdsdsd2",
                'status'=>'1',
            ],

        ]);
    }
}
