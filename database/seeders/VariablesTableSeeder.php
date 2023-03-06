<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class VariablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('variables')->truncate();

        $variables = [
            [
                'key'  => 'fruit',
                'value' => 'Fruit',
                'type' => 'tree.type'
            ],
            [
                'key'  => 'hardwood',
                'value' => 'Hardwood',
                'type' => 'tree.type'
            ],
            [
                'key'  => 'planting',
                'value' => 'Planting',
                'type' => 'tree.status'
            ],
            [
                'key'  => 'planted',
                'value' => 'Planted',
                'type' => 'tree.status'
            ],
            [
                'key'  => 'seedling',
                'value' => 'Seedling',
                'type' => 'tree.status'
            ],
            [
                'key'  => 'full_grown',
                'value' => 'Full Grown',
                'type' => 'tree.status'
            ],
            [
                'key'  => 'mango',
                'value' => 'Mango',
                'type' => 'tree.species'
            ],
            [
                'key'  => 'durian',
                'value' => 'Durian',
                'type' => 'tree.species'
            ],
            [
                'key'  => 'lanzones',
                'value' => 'Lanzones',
                'type' => 'tree.species'
            ],
            [
                'key'  => 'mangosteen',
                'value' => 'Mangosteen',
                'type' => 'tree.species'
            ],
            [
                'key'  => 'major',
                'value' => 'Major',
                'type' => 'sponsor.type'
            ],
            [
                'key'  => 'minor',
                'value' => 'Minor',
                'type' => 'sponsor.type'
            ],
            [
                'key'  => 'major',
                'value' => 'Major',
                'type' => 'sponsor.type'
            ],
            [
                'key'  => 'internal',
                'value' => 'Internal',
                'type' => 'organization.type'
            ],
            [
                'key'  => 'lgu',
                'value' => 'LGU',
                'type' => 'organization.type'
            ],
            [
                'key'  => 'ngo',
                'value' => 'NGO',
                'type' => 'organization.type'
            ],
            [
                'key'  => 'corporate',
                'value' => 'Corporate',
                'type' => 'organization.type'
            ],
            [
                'key'  => 'Civic',
                'value' => 'Civic',
                'type' => 'organization.type'
            ],
        ];

        foreach( $variables as $variable ){
            DB::table('variables')->insert(
                $variable
            );
        }

    }
}
