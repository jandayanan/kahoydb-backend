<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \DB::table('activities')->truncate();

        $array = [
            [
                'parent_organization_id'  => 1,
                'child_organization_id' => null,
                'name' => 'Mintal Tree Planting',
                'start_date' => '2023-02-01',
                'end_date' => '2023-02-15',
                'activity_status' => 'active'
            ],
            [
                'parent_organization_id'  => 1,
                'child_organization_id' => null,
                'name' => 'Marilog Tree Planting',
                'start_date' => '2023-03-01',
                'end_date' => '2023-02-27',
                'activity_status' => 'active'
            ]
        ];

        foreach( $array as $value ){
            \DB::table('activities')->insert(
                $value
            );
        }

    }
}
