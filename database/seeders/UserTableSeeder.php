<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $employee_data = [];
        $user_data = [];
        $i = 1;

        $users = [
            [
                'first_name'  => 'Harryn Glyde',
                'last_name' => 'Llait'
            ],
            [
                'first_name'  => 'Jan Koichi',
                'last_name' => 'Dayanan',
            ],
            [
                'first_name'  => 'Miguel',
                'last_name' => 'Dorado'
            ]
        ];

        foreach( $users as $key => $value ){
            $i = $i + 1;
            $full_name = $value["first_name"] . " " . $value["last_name"];
            $date = Carbon::now()->format('Y-m-d H:i:s');
            $username =
                strtolower(
                    substr( $value["first_name"], 0, 1) . str_replace(" ", "_", $value["last_name"] )
                );

            $email = $username . "@" . $faker->freeEmailDomain ();

            $data = [];
            $user = [];

            $data[ "id" ] = $i;
            $data[ "full_name" ] = $full_name;
            $data[ "first_name" ] = $value["first_name"];
            $data[ "last_name" ] = $value["last_name"];
            $data[ "email" ] = $email;
            $data[ "contact_number" ] = $faker->phoneNumber ();
            $data[ "status" ] = 'active';
            $data[ "created_at" ] = $date;
            $data[ "updated_at" ] = $date;

            $user['entity_id'] = $i;
            $user['username'] = $username;
            $user['password'] = bcrypt('Test@123');
            $user['created_at'] = $date;
            $user['updated_at'] = $date;

            $employee_data[] = $data;
            $user_data[] = $user;
        }

        \DB::table('entities')->insert($employee_data);
        \DB::table('users')->insert($user_data);
    }
}
