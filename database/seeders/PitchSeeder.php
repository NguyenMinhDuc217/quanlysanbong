<?php

namespace Database\Seeders;

use App\Models\Pitchs;
use Illuminate\Database\Seeder;

class PitchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pitchs::insert([
            [
                'id' => 1,
                'name' => 'Sân A',
                'price' => '120000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '5',
                'avartar' => 'sana.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '4',
                'total_rating' => 45,
                'total_set' => 78,
                'status' => '',
            ],
            [
                'id' => 2,
                'name' => 'Sân B',
                'price' => '120000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '5',
                'avartar' => 'sanb.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '4.5',
                'total_rating' => 65,
                'total_set' => 94,
                'status' => '',
            ],
            [
                'id' => 3,
                'name' => 'Sân C',
                'price' => '120000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '5',
                'avartar' => 'sanc.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '3.5',
                'total_rating' => 34,
                'total_set' => 40,
                'status' => '',
            ],
            [
                'id' => 4,
                'name' => 'Sân D',
                'price' => '120000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '5',
                'avartar' => 'sand.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '4',
                'total_rating' => 50,
                'total_set' => 62,
                'status' => '',
            ],
            [
                'id' => 5,
                'name' => 'Sân E',
                'price' => '120000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '5',
                'avartar' => 'sane.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '5',
                'total_rating' => 41,
                'total_set' => 54,
                'status' => '',
            ],
            [
                'id' => 6,
                'name' => 'Sân F',
                'price' => '120000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '5',
                'avartar' => 'sanf.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '3.5',
                'total_rating' => 28,
                'total_set' => 39,
                'status' => '',
            ],
            [
                'id' => 7,
                'name' => 'Sân G',
                'price' => '120000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '5',
                'avartar' => 'sang.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '4',
                'total_rating' => 46,
                'total_set' => 64,
                'status' => '',
            ],
            [
                'id' => 8,
                'name' => 'Sân H',
                'price' => '120000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '5',
                'avartar' => 'sanh.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '5',
                'total_rating' => 80,
                'total_set' => 95,
                'status' => '',
            ],
            [
                'id' => 9,
                'name' => 'Sân I',
                'price' => '120000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '5',
                'avartar' => 'sani.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '4',
                'total_rating' => 38,
                'total_set' => 50,
                'status' => '',
            ],
            [
                'id' => 10,
                'name' => 'Sân J',
                'price' => '120000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '5',
                'avartar' => 'sanj.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '3.5',
                'total_rating' => 20,
                'total_set' => 31,
                'status' => '',
            ],
            [
                'id' => 11,
                'name' => 'Sân K',
                'price' => '200000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '7',
                'avartar' => 'sank.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '4',
                'total_rating' => 101,
                'total_set' => 112,
                'status' => '',
            ],
            [
                'id' => 12,
                'name' => 'Sân L',
                'price' => '200000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '7',
                'avartar' => 'sanl.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '5',
                'total_rating' => 62,
                'total_set' => 103,
                'status' => '',
            ],
            [
                'id' => 13,
                'name' => 'Sân M',
                'price' => '200000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '7',
                'avartar' => 'sanm.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '3.5',
                'total_rating' => 28,
                'total_set' => 39,
                'status' => '',
            ],
            [
                'id' => 14,
                'name' => 'Sân N',
                'price' => '200000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '7',
                'avartar' => 'sann.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '4',
                'total_rating' => 54,
                'total_set' => 72,
                'status' => '',
            ],
            [
                'id' => 15,
                'name' => 'Sân O',
                'price' => '200000',
                'describe' => 'Sân bóng đá mini cỏ nhân tạo',
                'type_pitch' => '7',
                'avartar' => 'sano.jpg',
                'screenshort' => '["sana_sc1.jpg","sana_sc2.jpg"]',
                'average_rating' => '4.5',
                'total_rating' => 50,
                'total_set' => 60,
                'status' => '',
            ],
        ]);
    }
}