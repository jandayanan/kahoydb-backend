<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->truncate();

        $array = [
            [
                'organization_type' => 'internal',
                'full_name' => '10th Infantry Division'
            ],
            [
                'organization_type' => 'internal',
                'full_name' => 'Karancho'
            ],
            [
                'parent_organization_id'  => 1,
                'organization_type' => 'internal',
                'full_name' => '1001st Brigade'
            ],
            [
                'parent_organization_id'  => 1,
                'organization_type' => 'internal',
                'full_name' => '1002nd Brigade'
            ],
            [
                'parent_organization_id'  => 1,
                'organization_type' => 'internal',
                'full_name' => '62nd Brigade'
            ]
        ];
        foreach( $array as $value ){
            $entity_params['full_name'] = $value['full_name'];
            $entity_id = DB::table('entities')->insertGetId(
                $entity_params
            );
            $organization_param['entity_id'] = $entity_id;
            $organization_param['organization_type'] = $value['organization_type'];
            $organization_param['parent_organization_id'] = $value['parent_organization_id'] ?? null;
            DB::table('organizations')->insertGetId(
                $organization_param
            );
        }
    }
}
