<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Services;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Services::insert([
            [
                'name' => 'Nước',
                'price' => 15000,
            ],
            [
                'name' => 'Áo đấu',
                'price' => 20000,
            ],
            [
                'name' => 'Trọng tài',
                'price' => 200000,
            ]
        ]);
    }
}
