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
                'key'  => 'planted',
                'value' => 'Planted',
                'type' => 'tree.status'
            ],
            [
                'key'  => 'planting',
                'value' => 'Planting',
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
        ];

        foreach( $variables as $variable ){
            DB::table('variables')->insert(
                $variable
            );
        }

    }
}
