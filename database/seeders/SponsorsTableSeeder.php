<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class SponsorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sponsors')->truncate();

        $array = [
            [
                'organization_id'  => 2,
                'sponsorship_type' => 'major'
            ],
            [
                'organization_id'  => 3,
                'sponsorship_type' => 'organizer'
            ]
        ];

        foreach( $array as $value ){
            DB::table('sponsors')->insert(
                $value
            );
        }

    }
}
