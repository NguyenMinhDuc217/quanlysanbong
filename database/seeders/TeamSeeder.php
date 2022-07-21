<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teams;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teams::insert([
            [
                'user_name' => 'Thinh',
                'team_name' => 'Team thắng',
                'team_member'=>'thinh khang hoang duc minh',
                'link'=>'fb.com/xuanthinh',
            ],
            [
                'user_name' => 'Đức',
                'team_name' => 'Team AKK',
                'team_member'=>'hieu nhan nghia hoang thinh',
                'link'=>'fb.com/nmd111',
            ],
            [
                'user_name' => 'Thinh',
                'team_name' => 'Team TTN',
                'team_member'=>'thinh AN Khang Phat Tài',
                'link'=>'fb.com/nmh288',
            ],
            [
                'user_name' => 'Thinh',
                'team_name' => 'Team thắng',
                'team_member'=>'Phát Nghĩ Tài Lộc An',
                'link'=>'fb.com/thinh333',
            ]
        ]);
    }
}
