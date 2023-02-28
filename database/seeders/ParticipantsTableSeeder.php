<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ParticipantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $participant_data = [];
        $entry = 1000; // Number of entry to be inserted
        $activity_id = 1; // ID of an activity

        for( $i = 0; $i <= $entry; $i++ ){
            $data[ "entity_id" ] = $i + 1;
            $data[ "activity_id" ] = $activity_id;
            $data[ "participant_status" ] = 'active';

            $participant_data[] = $data;
        }

        \DB::table('participants')->insert($participant_data);
    }
}
