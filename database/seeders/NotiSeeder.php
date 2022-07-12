<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notifications;

class NotiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notifications::insert([
            [
                'title' => 'Thông báo khuyến mãi',
                'content' => 'Thông báo khuyến mãi 10% từ ngày 22/7/2022 đến 28/7/2022 sân H',
            ],
            [
                'title' => 'Thông báo khuyến mãi',
                'content' => 'Thông báo khuyến mãi 20% từ ngày 22/7/2022 đến 28/7/2022 sân E',
            ],
            [
                'title' => 'Thông báo khuyến mãi',
                'content' => 'Thông báo khuyến mãi 10% từ ngày 22/7/2022 đến 28/7/2022 sân O',
            ],
            [
                'title' => 'Thông báo khuyến mãi',
                'content' => 'Thông báo khuyến mãi 10% từ ngày 22/7/2022 đến 28/7/2022 sân A',
            ],
            [
                'title' => 'Thông báo khuyến mãi',
                'content' => 'Thông báo khuyến mãi 10% từ ngày 22/7/2022 đến 28/7/2022 sân A',
            ],
        ]);
    }
}
