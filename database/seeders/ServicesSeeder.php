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
                'name' => 'Nước suối',
                'price' => 5000,
            ],
            [
                'name' => 'Revive chanh muối',
                'price' => 5000,
            ],
            [
                'name' => 'Áo bib',
                'price' => 20000,
            ],
            [
                'name' => 'Trọng tài',
                'price' => 200000,
            ]
        ]);
    }
}
