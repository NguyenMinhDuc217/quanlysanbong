<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            SetPitchSeeder::class,
            UserSeeder::class,
            PitchSeeder::class,
            SettingSeeder::class,
            ServicesSeeder::class,
            TicketSeeder::class,
            DetailTicketSeeder::class,
            NotiSeeder::class,
            TeamSeeder::class,
        ]);
    }
}
