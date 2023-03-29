<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tree_data = [];
        $entry = 1000; // Number of entry to be inserted
        $activity_id = 3; // ID of an activity
        $tree_type = 'fruit';
        $tree_species = ['durian', 'mango', 'lanzones', 'mangosteen'];
        $status = 'planted';

        for( $i = 0; $i <= $entry; $i++ ){
            $data["activity_id"] = $activity_id;
            $data["planter_id"] = rand(1,1000);
            $data["unique_id"] = quick_hash(now());
            $data["planted_at"] = 'Mintal';
            $data["donated_at"] = 'Mintal';
            $data['tree_type'] = $tree_type;
            $data['tree_species'] = array_rand($tree_species);
            $data['tree_status'] = $status;

            $tree_data[] = $data;
        }

        \DB::table('trees')->insert($tree_data);
    }
}
