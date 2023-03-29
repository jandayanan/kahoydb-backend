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
        \DB::table('trees')->truncate(); // Comment out this line if necessary
        $tree_entry = 100; // Number of entry to be inserted
        $activity_id = null; // ID of an activity; SET NULL FOR ALL ACTIVITIES
        if(!is_null($activity_id)) $activities = [$activity_id];
        else {
            $activities = \DB::table('activities')->pluck('id')->toArray();
            if(is_null($activities)) return;
        }
        $tree_type = 'fruit';
        $tree_species = ['durian', 'mango', 'lanzones', 'mangosteen'];
        $status = 'planted';

        foreach($activities as $activity_id_){
            $tree_data = [];
            $activity = \DB::table('activities')->find($activity_id_);
            if(is_null($activity)) break;

            for( $i = 0; $i <= $tree_entry; $i++ ){

                $data["activity_id"] = $activity_id_;
                $data["planter_id"] = rand(1,1000);
                $data["unique_id"] = quick_hash(now());
                $data["planted_at"] = 'Davao';
                $data["donated_at"] = 'Davao';
                $data['tree_type'] = $tree_type;
                $data['tree_species'] = $tree_species[array_rand($tree_species)];
                $data['tree_status'] = $status;

                // Random Date Based on Start & End Date
                $date_planted = rand(strtotime($activity->start_date), strtotime($activity->end_date));
                $data['created_at'] = date('Y-m-d H:i:s', $date_planted);

                $tree_data[] = $data;
            }

            \DB::table('trees')->insert($tree_data);
        }
    }
}
