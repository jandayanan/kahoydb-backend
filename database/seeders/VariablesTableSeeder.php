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
        ];

        foreach( $variables as $variable ){
            DB::table('variables')->insert(
                $variable
            );
        }

    }
}
