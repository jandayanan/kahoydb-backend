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
                'name' => 'Marilog Tree Planting',
                'start_date' => '2023-01-01',
                'end_date' => '2023-01-05',
                'activity_status' => 'active'
            ],
            [
                'parent_organization_id'  => 192,
                'child_organization_id' => null,
                'name' => 'Mintal Tree Planting',
                'start_date' => '2023-01-08',
                'end_date' => '2023-01-10',
                'activity_status' => 'active'
            ],
            [
                'parent_organization_id'  => 192,
                'child_organization_id' => null,
                'name' => 'Calinan Tree Planting',
                'start_date' => '2023-01-20',
                'end_date' => '2023-01-25',
                'activity_status' => 'active'
            ],
            [
                'parent_organization_id'  => 192,
                'child_organization_id' => null,
                'name' => 'Catalunan Tree Planting',
                'start_date' => '2023-02-03',
                'end_date' => '2023-01-05',
                'activity_status' => 'active'
            ],
            [
                'parent_organization_id'  => 192,
                'child_organization_id' => null,
                'name' => 'Tugbok Tree Planting',
                'start_date' => '2023-02-15',
                'end_date' => '2023-02-20',
                'activity_status' => 'active'
            ],
            [
                'parent_organization_id'  => 192,
                'child_organization_id' => null,
                'name' => 'Tacunan Tree Planting',
                'start_date' => '2023-03-01',
                'end_date' => '2023-03-05',
                'activity_status' => 'active'
            ],
            [
                'parent_organization_id'  => 192,
                'child_organization_id' => null,
                'name' => 'Malagos Tree Planting',
                'start_date' => '2023-03-10',
                'end_date' => '2023-03-13',
                'activity_status' => 'active'
            ],
            [
                'parent_organization_id'  => 192,
                'child_organization_id' => null,
                'name' => 'Bunawan Tree Planting',
                'start_date' => '2023-03-15',
                'end_date' => '2023-03-20',
                'activity_status' => 'active'
            ],
            [
                'parent_organization_id'  => 192,
                'child_organization_id' => null,
                'name' => 'Talomo Tree Planting',
                'start_date' => '2023-03-21',
                'end_date' => '2023-03-25',
                'activity_status' => 'active'
            ],
            [
                'parent_organization_id'  => 192,
                'child_organization_id' => null,
                'name' => 'Mandug Tree Planting',
                'start_date' => '2023-03-27',
                'end_date' => '2023-03-29',
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
