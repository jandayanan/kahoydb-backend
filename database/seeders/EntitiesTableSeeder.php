<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $entity_data = [];

        $entry = 1000; // Number of entry to insert

        for( $i = 0; $i <= $entry; $i++ ){
            $gender = rand( 0 , 1 );
            $first_name = $gender === 1 ? $faker->firstNameMale() : $faker->firstNameFemale();
            $last_name = $faker->lastName();
            $full_name = $first_name . " " . $last_name;
            $username =
                strtolower(
                    substr( $first_name, 0, 1) . str_replace(" ", "_", $last_name )
                );

            $email = $username . "@" . $faker->freeEmailDomain ();
            $date = Carbon::now()->format('Y-m-d H:i:s');
            $status = "active";

            $data = [];
            $data[ "full_name" ] = $full_name;
            $data[ "email" ] = $email;
            $data[ "contact_number" ] = $faker->phoneNumber ();
            $data[ "status" ] = $status;
            $data[ "created_at" ] = $date;
            $data[ "updated_at" ] = $date;

            $entity_data[] = $data;
        }

        \DB::table('entities')->insert($entity_data);
    }
}
