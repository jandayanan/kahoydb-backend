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
            UserTableSeeder::class,
            EntitiesTableSeeder::class,
            ActivitiesTableSeeder::class,
            ParticipantsTableSeeder::class,
            TreesTableSeeder::class,
            VariablesTableSeeder::class,
            OrganizationsTableSeeder::class,
            SponsorsTableSeeder::class
        ]);
    }
}
