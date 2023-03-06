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
        // Call the MoviesTableSeeder class to seed the movies table
        $this->call([
            MoviesTableSeeder::class,
        ]);
    }
}
