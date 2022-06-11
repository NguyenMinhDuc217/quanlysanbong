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
                'ten' => 'User',
                'email' => 'user@gmail.com',
                'password' => bcrypt('admin123'),
                'sdt'=>'0223233277',
                'dia_chi'=>'12A222,',
                'vi_tien'=>'89',
                'remember_token'=>"dsdsdsdsd"
            ]
        ]);
    }
}
