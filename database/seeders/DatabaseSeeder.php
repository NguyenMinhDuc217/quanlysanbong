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
<<<<<<< HEAD
           // AdminSeeder::class,
            // UserSeeder::class,
            //PitchSeeder::class,
=======
            AdminSeeder::class,
            UserSeeder::class,
            PitchSeeder::class,
            SettingSeeder::class,
            ServicesSeeder::class,

>>>>>>> thinh
        ]);
    }
}
