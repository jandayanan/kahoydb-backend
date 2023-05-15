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
            1 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Reserve Command',
                'parent_organization_id' => NULL,
            ],
            2 => [
                'organization_type' => 'internal',
                'full_name' => '1st Army Reserve Command (Luzon)',
                'parent_organization_id' => 1,
            ],
            3 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Army Reserve Command (Visayas)',
                'parent_organization_id' => 1,
            ],
            4 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Army Reserve Command (Mindanao)',
                'parent_organization_id' => 1,
            ],
            5 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Reserve Medical Service Command',
                'parent_organization_id' => 1,
            ],
            6 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Support Command',
                'parent_organization_id' => NULL,
            ],
            7 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Support Battalion',
                'parent_organization_id' => 6,
            ],
            8 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Aviation Regiment',
                'parent_organization_id' => 6,
            ],
            9 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Signal Regiment',
                'parent_organization_id' => 6,
            ],
            10 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Engineer Regiment',
                'parent_organization_id' => 6,
            ],
            11 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Logistics Support Regiment',
                'parent_organization_id' => 6,
            ],
            12 => [
                'organization_type' => 'internal',
                'full_name' => 'Mechanized Infantry Division',
                'parent_organization_id' => NULL,
            ],
            13 => [
                'organization_type' => 'internal',
                'full_name' => 'Mechanized Infantry Brigade',
                'parent_organization_id' => 12,
            ],
            14 => [
                'organization_type' => 'internal',
                'full_name' => 'Mechanized Infantry Battalion (MIB) 1',
                'parent_organization_id' => 12,
            ],
            15 => [
                'organization_type' => 'internal',
                'full_name' => 'MIB 2',
                'parent_organization_id' => 12,
            ],
            16 => [
                'organization_type' => 'internal',
                'full_name' => 'MIB 3',
                'parent_organization_id' => 12,
            ],
            17 => [
                'organization_type' => 'internal',
                'full_name' => 'Armor Brigade',
                'parent_organization_id' => 17,
            ],
            18 => [
                'organization_type' => 'internal',
                'full_name' => 'Armor Battalion (AB) 1',
                'parent_organization_id' => 17,
            ],
            19 => [
                'organization_type' => 'internal',
                'full_name' => 'AB 2',
                'parent_organization_id' => 17,
            ],
            20 => [
                'organization_type' => 'internal',
                'full_name' => 'AB 3',
                'parent_organization_id' => 17,
            ],
            21 => [
                'organization_type' => 'internal',
                'full_name' => 'Division Artillery Brigade',
                'parent_organization_id' => 21,
            ],
            22 => [
                'organization_type' => 'internal',
                'full_name' => 'Field Artillery Battalion (FAB) 1',
                'parent_organization_id' => 21,
            ],
            23 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 2',
                'parent_organization_id' => 21,
            ],
            24 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 3',
                'parent_organization_id' => 21,
            ],
            25 => [
                'organization_type' => 'internal',
                'full_name' => 'Air Defense Artillery Battery',
                'parent_organization_id' => 21,
            ],
            26 => [
                'organization_type' => 'internal',
                'full_name' => 'Light Reaction Division',
                'parent_organization_id' => NULL,
            ],
            27 => [
                'organization_type' => 'internal',
                'full_name' => 'Light Reaction Regiment',
                'parent_organization_id' => 26,
            ],
            28 => [
                'organization_type' => 'internal',
                'full_name' => 'Light Reaction Battalion (LRB) 1',
                'parent_organization_id' => 26,
            ],
            29 => [
                'organization_type' => 'internal',
                'full_name' => 'LRB 2',
                'parent_organization_id' => 26,
            ],
            30 => [
                'organization_type' => 'internal',
                'full_name' => 'LRB 3',
                'parent_organization_id' => 26,
            ],
            31 => [
                'organization_type' => 'internal',
                'full_name' => 'Airborne Regiment',
                'parent_organization_id' => 31,
            ],
            32 => [
                'organization_type' => 'internal',
                'full_name' => 'Airborne Battalion (ABN) 1',
                'parent_organization_id' => 31,
            ],
            33 => [
                'organization_type' => 'internal',
                'full_name' => 'ABN 2',
                'parent_organization_id' => 31,
            ],
            34 => [
                'organization_type' => 'internal',
                'full_name' => 'ABN 3',
                'parent_organization_id' => 31,
            ],
            35 => [
                'organization_type' => 'internal',
                'full_name' => 'Special Forces Regiment (Airborne)',
                'parent_organization_id' => 35,
            ],
            36 => [
                'organization_type' => 'internal',
                'full_name' => 'Special Forces Battalion (SFB) 1',
                'parent_organization_id' => 35,
            ],
            37 => [
                'organization_type' => 'internal',
                'full_name' => 'SFB 2',
                'parent_organization_id' => 35,
            ],
            38 => [
                'organization_type' => 'internal',
                'full_name' => 'SFB 3',
                'parent_organization_id' => 35,
            ],
            39 => [
                'organization_type' => 'internal',
                'full_name' => '1st Infantry Division',
                'parent_organization_id' => NULL,
            ],
            40 => [
                'organization_type' => 'internal',
                'full_name' => '101st Infantry Brigade',
                'parent_organization_id' => 39,
            ],
            41 => [
                'organization_type' => 'internal',
                'full_name' => '17th Infantry Battalion (IB)',
                'parent_organization_id' => 39,
            ],
            42 => [
                'organization_type' => 'internal',
                'full_name' => '42nd IB',
                'parent_organization_id' => 39,
            ],
            43 => [
                'organization_type' => 'internal',
                'full_name' => '49th IB',
                'parent_organization_id' => 39,
            ],
            44 => [
                'organization_type' => 'internal',
                'full_name' => '102nd Infantry Brigade',
                'parent_organization_id' => 44,
            ],
            45 => [
                'organization_type' => 'internal',
                'full_name' => '26th IB',
                'parent_organization_id' => 44,
            ],
            46 => [
                'organization_type' => 'internal',
                'full_name' => '45th IB',
                'parent_organization_id' => 44,
            ],
            47 => [
                'organization_type' => 'internal',
                'full_name' => '56th IB',
                'parent_organization_id' => 44,
            ],
            48 => [
                'organization_type' => 'internal',
                'full_name' => '103rd Infantry Brigade',
                'parent_organization_id' => 48,
            ],
            49 => [
                'organization_type' => 'internal',
                'full_name' => '15th IB',
                'parent_organization_id' => 48,
            ],
            50 => [
                'organization_type' => 'internal',
                'full_name' => '20th IB',
                'parent_organization_id' => 48,
            ],
            51 => [
                'organization_type' => 'internal',
                'full_name' => '82nd IB',
                'parent_organization_id' => 48,
            ],
            52 => [
                'organization_type' => 'internal',
                'full_name' => 'Division Artillery Brigade',
                'parent_organization_id' => 52,
            ],
            53 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 1',
                'parent_organization_id' => 52,
            ],
            54 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 2',
                'parent_organization_id' => 52,
            ],
            55 => [
                'organization_type' => 'internal',
                'full_name' => 'Air Defense Artillery Battery',
                'parent_organization_id' => 52,
            ],
            56 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Infantry Division',
                'parent_organization_id' => NULL,
            ],
            57 => [
                'organization_type' => 'internal',
                'full_name' => '201st Infantry Brigade',
                'parent_organization_id' => 56,
            ],
            58 => [
                'organization_type' => 'internal',
                'full_name' => '74th IB',
                'parent_organization_id' => 56,
            ],
            59 => [
                'organization_type' => 'internal',
                'full_name' => '76th IB',
                'parent_organization_id' => 56,
            ],
            60 => [
                'organization_type' => 'internal',
                'full_name' => '88th IB',
                'parent_organization_id' => 56,
            ],
            61 => [
                'organization_type' => 'internal',
                'full_name' => '202nd Infantry Brigade',
                'parent_organization_id' => 61,
            ],
            62 => [
                'organization_type' => 'internal',
                'full_name' => '16th IB',
                'parent_organization_id' => 61,
            ],
            63 => [
                'organization_type' => 'internal',
                'full_name' => '22nd IB',
                'parent_organization_id' => 61,
            ],
            64 => [
                'organization_type' => 'internal',
                'full_name' => '24th IB',
                'parent_organization_id' => 61,
            ],
            65 => [
                'organization_type' => 'internal',
                'full_name' => '203rd Infantry Brigade',
                'parent_organization_id' => 65,
            ],
            66 => [
                'organization_type' => 'internal',
                'full_name' => '21st IB',
                'parent_organization_id' => 65,
            ],
            67 => [
                'organization_type' => 'internal',
                'full_name' => '72nd IB',
                'parent_organization_id' => 65,
            ],
            68 => [
                'organization_type' => 'internal',
                'full_name' => '85th IB',
                'parent_organization_id' => 65,
            ],
            69 => [
                'organization_type' => 'internal',
                'full_name' => 'Division Artillery Brigade',
                'parent_organization_id' => 69,
            ],
            70 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 3',
                'parent_organization_id' => 69,
            ],
            71 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 4',
                'parent_organization_id' => 69,
            ],
            72 => [
                'organization_type' => 'internal',
                'full_name' => 'Air Defense Artillery Battery',
                'parent_organization_id' => 69,
            ],
            73 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Infantry Division',
                'parent_organization_id' => NULL,
            ],
            74 => [
                'organization_type' => 'internal',
                'full_name' => '301st Infantry Brigade',
                'parent_organization_id' => 73,
            ],
            75 => [
                'organization_type' => 'internal',
                'full_name' => '67th IB',
                'parent_organization_id' => 73,
            ],
            76 => [
                'organization_type' => 'internal',
                'full_name' => '81st IB',
                'parent_organization_id' => 73,
            ],
            77 => [
                'organization_type' => 'internal',
                'full_name' => '84th IB',
                'parent_organization_id' => 73,
            ],
            78 => [
                'organization_type' => 'internal',
                'full_name' => '302nd Infantry Brigade',
                'parent_organization_id' => 78,
            ],
            79 => [
                'organization_type' => 'internal',
                'full_name' => '58th IB',
                'parent_organization_id' => 78,
            ],
            80 => [
                'organization_type' => 'internal',
                'full_name' => '59th IB',
                'parent_organization_id' => 78,
            ],
            81 => [
                'organization_type' => 'internal',
                'full_name' => '60th IB',
                'parent_organization_id' => 78,
            ],
            82 => [
                'organization_type' => 'internal',
                'full_name' => '303rd Infantry Brigade',
                'parent_organization_id' => 82,
            ],
            83 => [
                'organization_type' => 'internal',
                'full_name' => '29th IB',
                'parent_organization_id' => 82,
            ],
            84 => [
                'organization_type' => 'internal',
                'full_name' => '82nd IB',
                'parent_organization_id' => 82,
            ],
            85 => [
                'organization_type' => 'internal',
                'full_name' => '83rd IB',
                'parent_organization_id' => 82,
            ],
            86 => [
                'organization_type' => 'internal',
                'full_name' => 'Division Artillery Brigade',
                'parent_organization_id' => 86,
            ],
            87 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 5',
                'parent_organization_id' => 86,
            ],
            88 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 6',
                'parent_organization_id' => 86,
            ],
            89 => [
                'organization_type' => 'internal',
                'full_name' => 'Air Defense Artillery Battery',
                'parent_organization_id' => 86,
            ],
            90 => [
                'organization_type' => 'internal',
                'full_name' => '4th Infantry Division',
                'parent_organization_id' => NULL,
            ],
            91 => [
                'organization_type' => 'internal',
                'full_name' => '401st Infantry Brigade',
                'parent_organization_id' => 90,
            ],
            92 => [
                'organization_type' => 'internal',
                'full_name' => '26th IB',
                'parent_organization_id' => 90,
            ],
            93 => [
                'organization_type' => 'internal',
                'full_name' => '29th IB',
                'parent_organization_id' => 90,
            ],
            94 => [
                'organization_type' => 'internal',
                'full_name' => '30th IB',
                'parent_organization_id' => 90,
            ],
            95 => [
                'organization_type' => 'internal',
                'full_name' => '402nd Infantry Brigade',
                'parent_organization_id' => 95,
            ],
            96 => [
                'organization_type' => 'internal',
                'full_name' => '32nd IB',
                'parent_organization_id' => 95,
            ],
            97 => [
                'organization_type' => 'internal',
                'full_name' => '36th IB',
                'parent_organization_id' => 95,
            ],
            98 => [
                'organization_type' => 'internal',
                'full_name' => '38th IB',
                'parent_organization_id' => 95,
            ],
            99 => [
                'organization_type' => 'internal',
                'full_name' => '403rd Infantry Brigade',
                'parent_organization_id' => 99,
            ],
            100 => [
                'organization_type' => 'internal',
                'full_name' => '16th IB',
                'parent_organization_id' => 99,
            ],
            101 => [
                'organization_type' => 'internal',
                'full_name' => '29th IB',
                'parent_organization_id' => 99,
            ],
            102 => [
                'organization_type' => 'internal',
                'full_name' => '30th IB',
                'parent_organization_id' => 99,
            ],
            103 => [
                'organization_type' => 'internal',
                'full_name' => 'Division Artillery Brigade',
                'parent_organization_id' => 103,
            ],
            104 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 7',
                'parent_organization_id' => 103,
            ],
            105 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 8',
                'parent_organization_id' => 103,
            ],
            106 => [
                'organization_type' => 'internal',
                'full_name' => 'Air Defense Artillery Battery',
                'parent_organization_id' => 103,
            ],
            107 => [
                'organization_type' => 'internal',
                'full_name' => '5th Infantry Division',
                'parent_organization_id' => NULL,
            ],
            108 => [
                'organization_type' => 'internal',
                'full_name' => '501st Infantry Brigade',
                'parent_organization_id' => 107,
            ],
            109 => [
                'organization_type' => 'internal',
                'full_name' => '74th IB',
                'parent_organization_id' => 107,
            ],
            110 => [
                'organization_type' => 'internal',
                'full_name' => '76th IB',
                'parent_organization_id' => 107,
            ],
            111 => [
                'organization_type' => 'internal',
                'full_name' => '88th IB',
                'parent_organization_id' => 107,
            ],
            112 => [
                'organization_type' => 'internal',
                'full_name' => '502nd Infantry Brigade',
                'parent_organization_id' => 112,
            ],
            113 => [
                'organization_type' => 'internal',
                'full_name' => '16th IB',
                'parent_organization_id' => 112,
            ],
            114 => [
                'organization_type' => 'internal',
                'full_name' => '22nd IB',
                'parent_organization_id' => 112,
            ],
            115 => [
                'organization_type' => 'internal',
                'full_name' => '24th IB',
                'parent_organization_id' => 112,
            ],
            116 => [
                'organization_type' => 'internal',
                'full_name' => '503rd Infantry Brigade',
                'parent_organization_id' => 116,
            ],
            117 => [
                'organization_type' => 'internal',
                'full_name' => '21st IB',
                'parent_organization_id' => 116,
            ],
            118 => [
                'organization_type' => 'internal',
                'full_name' => '72nd IB',
                'parent_organization_id' => 116,
            ],
            119 => [
                'organization_type' => 'internal',
                'full_name' => '85th IB',
                'parent_organization_id' => 116,
            ],
            120 => [
                'organization_type' => 'internal',
                'full_name' => 'Division Artillery Brigade',
                'parent_organization_id' => 120,
            ],
            121 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 9',
                'parent_organization_id' => 120,
            ],
            122 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 10',
                'parent_organization_id' => 120,
            ],
            123 => [
                'organization_type' => 'internal',
                'full_name' => 'Air Defense Artillery Battery',
                'parent_organization_id' => 120,
            ],
            124 => [
                'organization_type' => 'internal',
                'full_name' => '6th Infantry Division',
                'parent_organization_id' => NULL,
            ],
            125 => [
                'organization_type' => 'internal',
                'full_name' => '601st Infantry Brigade',
                'parent_organization_id' => 124,
            ],
            126 => [
                'organization_type' => 'internal',
                'full_name' => '29th IB',
                'parent_organization_id' => 124,
            ],
            127 => [
                'organization_type' => 'internal',
                'full_name' => '36th IB',
                'parent_organization_id' => 124,
            ],
            128 => [
                'organization_type' => 'internal',
                'full_name' => '56th IB',
                'parent_organization_id' => 124,
            ],
            129 => [
                'organization_type' => 'internal',
                'full_name' => '602nd Infantry Brigade',
                'parent_organization_id' => 129,
            ],
            130 => [
                'organization_type' => 'internal',
                'full_name' => '29th IB',
                'parent_organization_id' => 129,
            ],
            131 => [
                'organization_type' => 'internal',
                'full_name' => '30th IB',
                'parent_organization_id' => 129,
            ],
            132 => [
                'organization_type' => 'internal',
                'full_name' => '54th IB',
                'parent_organization_id' => 129,
            ],
            133 => [
                'organization_type' => 'internal',
                'full_name' => '603rd Infantry Brigade',
                'parent_organization_id' => 133,
            ],
            134 => [
                'organization_type' => 'internal',
                'full_name' => '8th IB',
                'parent_organization_id' => 133,
            ],
            135 => [
                'organization_type' => 'internal',
                'full_name' => '53rd IB',
                'parent_organization_id' => 133,
            ],
            136 => [
                'organization_type' => 'internal',
                'full_name' => '55th IB',
                'parent_organization_id' => 133,
            ],
            137 => [
                'organization_type' => 'internal',
                'full_name' => 'Division Artillery Brigade',
                'parent_organization_id' => 137,
            ],
            138 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 11',
                'parent_organization_id' => 137,
            ],
            139 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 12',
                'parent_organization_id' => 137,
            ],
            140 => [
                'organization_type' => 'internal',
                'full_name' => 'Air Defense Artillery Battery',
                'parent_organization_id' => 137,
            ],
            141 => [
                'organization_type' => 'internal',
                'full_name' => '7th Infantry Division',
                'parent_organization_id' => NULL,
            ],
            142 => [
                'organization_type' => 'internal',
                'full_name' => '701st Infantry Brigade',
                'parent_organization_id' => 141,
            ],
            143 => [
                'organization_type' => 'internal',
                'full_name' => '1st IB',
                'parent_organization_id' => 141,
            ],
            144 => [
                'organization_type' => 'internal',
                'full_name' => '5th IB',
                'parent_organization_id' => 141,
            ],
            145 => [
                'organization_type' => 'internal',
                'full_name' => '32nd IB',
                'parent_organization_id' => 141,
            ],
            146 => [
                'organization_type' => 'internal',
                'full_name' => '702nd Infantry Brigade',
                'parent_organization_id' => 146,
            ],
            147 => [
                'organization_type' => 'internal',
                'full_name' => '12th IB',
                'parent_organization_id' => 146,
            ],
            148 => [
                'organization_type' => 'internal',
                'full_name' => '65th IB',
                'parent_organization_id' => 146,
            ],
            149 => [
                'organization_type' => 'internal',
                'full_name' => '71st IB',
                'parent_organization_id' => 146,
            ],
            150 => [
                'organization_type' => 'internal',
                'full_name' => '703rd Infantry Brigade',
                'parent_organization_id' => 150,
            ],
            151 => [
                'organization_type' => 'internal',
                'full_name' => '3rd IB',
                'parent_organization_id' => 150,
            ],
            152 => [
                'organization_type' => 'internal',
                'full_name' => '8th IB',
                'parent_organization_id' => 150,
            ],
            153 => [
                'organization_type' => 'internal',
                'full_name' => '68th IB',
                'parent_organization_id' => 150,
            ],
            154 => [
                'organization_type' => 'internal',
                'full_name' => 'Division Artillery Brigade',
                'parent_organization_id' => 154,
            ],
            155 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 13',
                'parent_organization_id' => 154,
            ],
            156 => [
                'organization_type' => 'internal',
                'full_name' => 'FAB 14',
                'parent_organization_id' => 154,
            ],
            157 => [
                'organization_type' => 'internal',
                'full_name' => 'Air Defense Artillery Battery',
                'parent_organization_id' => 154,
            ],
            158 => [
                'organization_type' => 'internal',
                'full_name' => 'Special Forces Regiment (Airborne)',
                'parent_organization_id' => 158,
            ],
            159 => [
                'organization_type' => 'internal',
                'full_name' => '1st Special Forces Battalion',
                'parent_organization_id' => 158,
            ],
            160 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Special Forces Battalion',
                'parent_organization_id' => 158,
            ],
            161 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Special Forces Battalion',
                'parent_organization_id' => 158,
            ],
            162 => [
                'organization_type' => 'internal',
                'full_name' => 'Scout Ranger Regiment',
                'parent_organization_id' => 162,
            ],
            163 => [
                'organization_type' => 'internal',
                'full_name' => '1st Scout Ranger Battalion',
                'parent_organization_id' => 162,
            ],
            164 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Scout Ranger Battalion',
                'parent_organization_id' => 162,
            ],
            165 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Scout Ranger Battalion',
                'parent_organization_id' => 162,
            ],
            166 => [
                'organization_type' => 'internal',
                'full_name' => '8th Infantry Division',
                'parent_organization_id' => NULL,
            ],
            167 => [
                'organization_type' => 'internal',
                'full_name' => '802nd Infantry Brigade "Peerless"',
                'parent_organization_id' => 166,
            ],
            168 => [
                'organization_type' => 'internal',
                'full_name' => '20IB',
                'parent_organization_id' => 166,
            ],
            169 => [
                'organization_type' => 'internal',
                'full_name' => '45IB',
                'parent_organization_id' => 166,
            ],
            170 => [
                'organization_type' => 'internal',
                'full_name' => '93IB',
                'parent_organization_id' => 166,
            ],
            171 => [
                'organization_type' => 'internal',
                'full_name' => '803rd Infantry Brigade "Peloton"',
                'parent_organization_id' => 171,
            ],
            172 => [
                'organization_type' => 'internal',
                'full_name' => '11IB',
                'parent_organization_id' => 171,
            ],
            173 => [
                'organization_type' => 'internal',
                'full_name' => '40IB',
                'parent_organization_id' => 171,
            ],
            174 => [
                'organization_type' => 'internal',
                'full_name' => '72IB',
                'parent_organization_id' => 171,
            ],
            175 => [
                'organization_type' => 'internal',
                'full_name' => '804th Infantry Brigade "Steadfast"',
                'parent_organization_id' => 175,
            ],
            176 => [
                'organization_type' => 'internal',
                'full_name' => '26IB',
                'parent_organization_id' => 175,
            ],
            177 => [
                'organization_type' => 'internal',
                'full_name' => '30IB',
                'parent_organization_id' => 175,
            ],
            178 => [
                'organization_type' => 'internal',
                'full_name' => '88IB',
                'parent_organization_id' => 175,
            ],
            179 => [
                'organization_type' => 'internal',
                'full_name' => '9th Infantry Division',
                'parent_organization_id' => NULL,
            ],
            180 => [
                'organization_type' => 'internal',
                'full_name' => '901st Infantry Brigade "Fighter"',
                'parent_organization_id' => 179,
            ],
            181 => [
                'organization_type' => 'internal',
                'full_name' => '15IB',
                'parent_organization_id' => 179,
            ],
            182 => [
                'organization_type' => 'internal',
                'full_name' => '30IB',
                'parent_organization_id' => 179,
            ],
            183 => [
                'organization_type' => 'internal',
                'full_name' => '46IB',
                'parent_organization_id' => 179,
            ],
            184 => [
                'organization_type' => 'internal',
                'full_name' => '902nd Infantry Brigade "Defender"',
                'parent_organization_id' => 184,
            ],
            185 => [
                'organization_type' => 'internal',
                'full_name' => '20IB',
                'parent_organization_id' => 184,
            ],
            186 => [
                'organization_type' => 'internal',
                'full_name' => '84IB',
                'parent_organization_id' => 184,
            ],
            187 => [
                'organization_type' => 'internal',
                'full_name' => '89IB',
                'parent_organization_id' => 184,
            ],
            188 => [
                'organization_type' => 'internal',
                'full_name' => '903rd Infantry Brigade "Patriot"',
                'parent_organization_id' => 188,
            ],
            189 => [
                'organization_type' => 'internal',
                'full_name' => '65IB',
                'parent_organization_id' => 188,
            ],
            190 => [
                'organization_type' => 'internal',
                'full_name' => '67IB',
                'parent_organization_id' => 188,
            ],
            191 => [
                'organization_type' => 'internal',
                'full_name' => '88IB',
                'parent_organization_id' => 188,
            ],
            192 => [
                'organization_type' => 'internal',
                'full_name' => '10th Infantry Division',
                'parent_organization_id' => NULL,
            ],
            193 => [
                'organization_type' => 'internal',
                'full_name' => '1001st Infantry Brigade "Bayanihan"',
                'parent_organization_id' => 192,
            ],
            194 => [
                'organization_type' => 'internal',
                'full_name' => '11IB',
                'parent_organization_id' => 192,
            ],
            195 => [
                'organization_type' => 'internal',
                'full_name' => '16IB',
                'parent_organization_id' => 192,
            ],
            196 => [
                'organization_type' => 'internal',
                'full_name' => '71IB',
                'parent_organization_id' => 192,
            ],
            197 => [
                'organization_type' => 'internal',
                'full_name' => '1002nd Infantry Brigade "Lion"',
                'parent_organization_id' => 197,
            ],
            198 => [
                'organization_type' => 'internal',
                'full_name' => '26IB',
                'parent_organization_id' => 197,
            ],
            199 => [
                'organization_type' => 'internal',
                'full_name' => '72IB',
                'parent_organization_id' => 197,
            ],
            200 => [
                'organization_type' => 'internal',
                'full_name' => '85IB',
                'parent_organization_id' => 197,
            ],
            201 => [
                'organization_type' => 'internal',
                'full_name' => '1003rd Infantry Brigade "Raptor"',
                'parent_organization_id' => 201,
            ],
            202 => [
                'organization_type' => 'internal',
                'full_name' => '25IB',
                'parent_organization_id' => 201,
            ],
            203 => [
                'organization_type' => 'internal',
                'full_name' => '67IB',
                'parent_organization_id' => 201,
            ],
            204 => [
                'organization_type' => 'internal',
                'full_name' => '76IB',
                'parent_organization_id' => 201,
            ],
            205 => [
                'organization_type' => 'internal',
                'full_name' => '11th Infantry Division',
                'parent_organization_id' => NULL,
            ],
            206 => [
                'organization_type' => 'internal',
                'full_name' => '1101st Infantry Brigade "Alakdan"',
                'parent_organization_id' => 205,
            ],
            207 => [
                'organization_type' => 'internal',
                'full_name' => '11IB',
                'parent_organization_id' => 205,
            ],
            208 => [
                'organization_type' => 'internal',
                'full_name' => '19IB',
                'parent_organization_id' => 205,
            ],
            209 => [
                'organization_type' => 'internal',
                'full_name' => '29IB',
                'parent_organization_id' => 205,
            ],
            210 => [
                'organization_type' => 'internal',
                'full_name' => '1102nd Infantry Brigade "Kaugnay"',
                'parent_organization_id' => 210,
            ],
            211 => [
                'organization_type' => 'internal',
                'full_name' => '14IB',
                'parent_organization_id' => 210,
            ],
            212 => [
                'organization_type' => 'internal',
                'full_name' => '20IB',
                'parent_organization_id' => 210,
            ],
            213 => [
                'organization_type' => 'internal',
                'full_name' => '74IB',
                'parent_organization_id' => 210,
            ],
            214 => [
                'organization_type' => 'internal',
                'full_name' => '1103rd Infantry Brigade "Agila"',
                'parent_organization_id' => 214,
            ],
            215 => [
                'organization_type' => 'internal',
                'full_name' => '15IB',
                'parent_organization_id' => 214,
            ],
            216 => [
                'organization_type' => 'internal',
                'full_name' => '16IB',
                'parent_organization_id' => 214,
            ],
            217 => [
                'organization_type' => 'internal',
                'full_name' => '45IB',
                'parent_organization_id' => 214,
            ],
            218 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Reserve Command',
                'parent_organization_id' => NULL,
            ],
            219 => [
                'organization_type' => 'internal',
                'full_name' => '1st Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            220 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            221 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            222 => [
                'organization_type' => 'internal',
                'full_name' => '4th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            223 => [
                'organization_type' => 'internal',
                'full_name' => '5th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            224 => [
                'organization_type' => 'internal',
                'full_name' => '6th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            225 => [
                'organization_type' => 'internal',
                'full_name' => '7th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            226 => [
                'organization_type' => 'internal',
                'full_name' => '8th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            227 => [
                'organization_type' => 'internal',
                'full_name' => '9th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            228 => [
                'organization_type' => 'internal',
                'full_name' => '10th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            229 => [
                'organization_type' => 'internal',
                'full_name' => '11th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            230 => [
                'organization_type' => 'internal',
                'full_name' => '12th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            231 => [
                'organization_type' => 'internal',
                'full_name' => '13th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            232 => [
                'organization_type' => 'internal',
                'full_name' => '14th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            233 => [
                'organization_type' => 'internal',
                'full_name' => '15th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            234 => [
                'organization_type' => 'internal',
                'full_name' => '16th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            235 => [
                'organization_type' => 'internal',
                'full_name' => '17th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            236 => [
                'organization_type' => 'internal',
                'full_name' => '18th Army Ready Reserve Infantry Brigade',
                'parent_organization_id' => 218,
            ],
            237 => [
                'organization_type' => 'internal',
                'full_name' => 'Philippine Army Aviation Regiment',
                'parent_organization_id' => NULL,
            ],
            238 => [
                'organization_type' => 'internal',
                'full_name' => 'Tactical Operations Group 1',
                'parent_organization_id' => 237,
            ],
            239 => [
                'organization_type' => 'internal',
                'full_name' => 'Tactical Operations Group 2',
                'parent_organization_id' => 237,
            ],
            240 => [
                'organization_type' => 'internal',
                'full_name' => 'Tactical Operations Group 3',
                'parent_organization_id' => 237,
            ],
            241 => [
                'organization_type' => 'internal',
                'full_name' => 'Tactical Operations Group 4',
                'parent_organization_id' => 237,
            ],
            242 => [
                'organization_type' => 'internal',
                'full_name' => 'Aviation Support Battalion',
                'parent_organization_id' => 237,
            ],
            243 => [
                'organization_type' => 'internal',
                'full_name' => 'Mechanized Infantry Division',
                'parent_organization_id' => NULL,
            ],
            244 => [
                'organization_type' => 'internal',
                'full_name' => 'Mechanized Infantry Division Headquarters and Headquarters Service Battalion',
                'parent_organization_id' => 243,
            ],
            245 => [
                'organization_type' => 'internal',
                'full_name' => 'Mechanized Infantry Division Support Battalion',
                'parent_organization_id' => 243,
            ],
            246 => [
                'organization_type' => 'internal',
                'full_name' => '1st Mechanized Infantry Brigade',
                'parent_organization_id' => 243,
            ],
            247 => [
                'organization_type' => 'internal',
                'full_name' => '1st Mechanized Infantry Battalion',
                'parent_organization_id' => 243,
            ],
            248 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Mechanized Infantry Battalion',
                'parent_organization_id' => 243,
            ],
            249 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Mechanized Infantry Battalion',
                'parent_organization_id' => 243,
            ],
            250 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Mechanized Infantry Brigade',
                'parent_organization_id' => 250,
            ],
            251 => [
                'organization_type' => 'internal',
                'full_name' => '4th Mechanized Infantry Battalion',
                'parent_organization_id' => 250,
            ],
            252 => [
                'organization_type' => 'internal',
                'full_name' => '5th Mechanized Infantry Battalion',
                'parent_organization_id' => 250,
            ],
            253 => [
                'organization_type' => 'internal',
                'full_name' => '6th Mechanized Infantry Battalion',
                'parent_organization_id' => 250,
            ],
            254 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Mechanized Infantry Brigade',
                'parent_organization_id' => 254,
            ],
            255 => [
                'organization_type' => 'internal',
                'full_name' => '7th Mechanized Infantry Battalion',
                'parent_organization_id' => 254,
            ],
            256 => [
                'organization_type' => 'internal',
                'full_name' => '8th Mechanized Infantry Battalion',
                'parent_organization_id' => 254,
            ],
            257 => [
                'organization_type' => 'internal',
                'full_name' => '9th Mechanized Infantry Battalion',
                'parent_organization_id' => 254,
            ],
            258 => [
                'organization_type' => 'internal',
                'full_name' => 'Mechanized Artillery Regiment',
                'parent_organization_id' => 258,
            ],
            259 => [
                'organization_type' => 'internal',
                'full_name' => '1st Mechanized Artillery Battery',
                'parent_organization_id' => 258,
            ],
            260 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Mechanized Artillery Battery',
                'parent_organization_id' => 258,
            ],
            261 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Mechanized Artillery Battery',
                'parent_organization_id' => 258,
            ],
            262 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Support Command',
                'parent_organization_id' => NULL,
            ],
            263 => [
                'organization_type' => 'internal',
                'full_name' => 'ASCOM Headquarters and Headquarters Service Battalion',
                'parent_organization_id' => 262,
            ],
            264 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Logistics Regiment',
                'parent_organization_id' => 262,
            ],
            265 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Signal Regiment',
                'parent_organization_id' => 262,
            ],
            266 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Engineer Brigade',
                'parent_organization_id' => 262,
            ],
            267 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Military Police Group',
                'parent_organization_id' => 262,
            ],
            268 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Finance Center',
                'parent_organization_id' => 262,
            ],
            269 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Medical Battalion',
                'parent_organization_id' => 262,
            ],
            270 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Training and Doctrine Command',
                'parent_organization_id' => 262,
            ],
            271 => [
                'organization_type' => 'internal',
                'full_name' => 'Special Operations Command',
                'parent_organization_id' => NULL,
            ],
            272 => [
                'organization_type' => 'internal',
                'full_name' => 'Special Operations Command Headquarters and Headquarters Service Battalion',
                'parent_organization_id' => 271,
            ],
            273 => [
                'organization_type' => 'internal',
                'full_name' => 'Special Forces Regiment (Airborne)',
                'parent_organization_id' => 271,
            ],
            274 => [
                'organization_type' => 'internal',
                'full_name' => '1st Special Forces Battalion (Airborne)',
                'parent_organization_id' => 271,
            ],
            275 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Special Forces Battalion (Airborne)',
                'parent_organization_id' => 271,
            ],
            276 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Special Forces Battalion (Airborne)',
                'parent_organization_id' => 271,
            ],
            277 => [
                'organization_type' => 'internal',
                'full_name' => 'Light Reaction Regiment (LRR)',
                'parent_organization_id' => 277,
            ],
            278 => [
                'organization_type' => 'internal',
                'full_name' => 'Light Reaction Battalion (LRR)',
                'parent_organization_id' => 277,
            ],
            279 => [
                'organization_type' => 'internal',
                'full_name' => 'Special Forces Combat Service Support Battalion',
                'parent_organization_id' => 277,
            ],
            280 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Aviation Battalion (Special Operations)',
                'parent_organization_id' => 280,
            ],
            281 => [
                'organization_type' => 'internal',
                'full_name' => 'Special Forces Regiment (Reserve)',
                'parent_organization_id' => 280,
            ],
            282 => [
                'organization_type' => 'internal',
                'full_name' => '1st Special Forces Battalion (Reserve)',
                'parent_organization_id' => 280,
            ],
            283 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Special Forces Battalion (Reserve)',
                'parent_organization_id' => 280,
            ],
            284 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Security and Escort Battalion',
                'parent_organization_id' => NULL,
            ],
            285 => [
                'organization_type' => 'internal',
                'full_name' => 'ASEB Headquarters and Headquarters Service Company',
                'parent_organization_id' => 284,
            ],
            286 => [
                'organization_type' => 'internal',
                'full_name' => '1st ASEB',
                'parent_organization_id' => 284,
            ],
            287 => [
                'organization_type' => 'internal',
                'full_name' => '2nd ASEB',
                'parent_organization_id' => 284,
            ],
            288 => [
                'organization_type' => 'internal',
                'full_name' => '3rd ASEB',
                'parent_organization_id' => 284,
            ],
            289 => [
                'organization_type' => 'internal',
                'full_name' => '4th ASEB',
                'parent_organization_id' => 284,
            ],
            290 => [
                'organization_type' => 'internal',
                'full_name' => '5th ASEB',
                'parent_organization_id' => 284,
            ],
            291 => [
                'organization_type' => 'internal',
                'full_name' => '6th ASEB',
                'parent_organization_id' => 284,
            ],
            292 => [
                'organization_type' => 'internal',
                'full_name' => 'Civil Military Operations Regiment',
                'parent_organization_id' => NULL,
            ],
            293 => [
                'organization_type' => 'internal',
                'full_name' => '11th Civil Military Operations Battalion',
                'parent_organization_id' => 292,
            ],
            294 => [
                'organization_type' => 'internal',
                'full_name' => '12th Civil Military Operations Battalion',
                'parent_organization_id' => 292,
            ],
            295 => [
                'organization_type' => 'internal',
                'full_name' => '14th Civil Military Operations Battalion',
                'parent_organization_id' => 292,
            ],
            296 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Intelligence and Security Group',
                'parent_organization_id' => NULL,
            ],
            297 => [
                'organization_type' => 'internal',
                'full_name' => 'AISG Headquarters and Headquarters Service Company',
                'parent_organization_id' => 296,
            ],
            298 => [
                'organization_type' => 'internal',
                'full_name' => '1st Military Intelligence Battalion',
                'parent_organization_id' => 296,
            ],
            299 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Military Intelligence Battalion',
                'parent_organization_id' => 296,
            ],
            300 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Military Intelligence Battalion',
                'parent_organization_id' => 296,
            ],
            301 => [
                'organization_type' => 'internal',
                'full_name' => '4th Military Intelligence Battalion',
                'parent_organization_id' => 296,
            ],
            302 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Signal Regiment',
                'parent_organization_id' => NULL,
            ],
            303 => [
                'organization_type' => 'internal',
                'full_name' => 'Signal Support Battalion',
                'parent_organization_id' => 302,
            ],
            304 => [
                'organization_type' => 'internal',
                'full_name' => '1st Signal Battalion',
                'parent_organization_id' => 302,
            ],
            305 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Signal Battalion',
                'parent_organization_id' => 302,
            ],
            306 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Signal Battalion',
                'parent_organization_id' => 302,
            ],
            307 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Training and Doctrine Command',
                'parent_organization_id' => NULL,
            ],
            308 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Training and Doctrine Command Headquarters and Headquarters Service Battalion',
                'parent_organization_id' => NULL,
            ],
            309 => [
                'organization_type' => 'internal',
                'full_name' => 'Army School System',
                'parent_organization_id' => 308,
            ],
            310 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Officer Candidate School',
                'parent_organization_id' => 308,
            ],
            311 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Officer Preparatory Course',
                'parent_organization_id' => 308,
            ],
            312 => [
                'organization_type' => 'internal',
                'full_name' => 'Officer Candidate School',
                'parent_organization_id' => 308,
            ],
            313 => [
                'organization_type' => 'internal',
                'full_name' => 'Basic Officers Leadership Course',
                'parent_organization_id' => 308,
            ],
            314 => [
                'organization_type' => 'internal',
                'full_name' => 'Advance Officers Leadership Course',
                'parent_organization_id' => 308,
            ],
            315 => [
                'organization_type' => 'internal',
                'full_name' => 'Senior Leaders Course',
                'parent_organization_id' => 308,
            ],
            316 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Basic Training',
                'parent_organization_id' => 308,
            ],
            317 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Reserve Officer Training Corps',
                'parent_organization_id' => 308,
            ],
            318 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Special Forces Training School',
                'parent_organization_id' => 308,
            ],
            319 => [
                'organization_type' => 'internal',
                'full_name' => 'Doctrine and Development Center',
                'parent_organization_id' => 308,
            ],
            320 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Medical Service',
                'parent_organization_id' => NULL,
            ],
            321 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Medical Service Headquarters and Headquarters Service Battalion',
                'parent_organization_id' => 320,
            ],
            322 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Medical Center',
                'parent_organization_id' => 320,
            ],
            323 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Medical Battalion',
                'parent_organization_id' => 320,
            ],
            324 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Dental Service',
                'parent_organization_id' => 320,
            ],
            325 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Veterinary Service',
                'parent_organization_id' => 320,
            ],
            326 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Armor Regiment',
                'parent_organization_id' => NULL,
            ],
            327 => [
                'organization_type' => 'internal',
                'full_name' => 'Armor Regiment Headquarters and Headquarters Service Battalion',
                'parent_organization_id' => 326,
            ],
            328 => [
                'organization_type' => 'internal',
                'full_name' => '1st Armor Battalion',
                'parent_organization_id' => 326,
            ],
            329 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Armor Battalion',
                'parent_organization_id' => 326,
            ],
            330 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Armor Battalion',
                'parent_organization_id' => 326,
            ],
            331 => [
                'organization_type' => 'internal',
                'full_name' => '4th Armor Battalion',
                'parent_organization_id' => 326,
            ],
            332 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Artillery Regiment',
                'parent_organization_id' => NULL,
            ],
            333 => [
                'organization_type' => 'internal',
                'full_name' => 'Artillery Regiment Headquarters and Headquarters Service Battalion',
                'parent_organization_id' => 332,
            ],
            334 => [
                'organization_type' => 'internal',
                'full_name' => '1st Field Artillery Battalion',
                'parent_organization_id' => 332,
            ],
            335 => [
                'organization_type' => 'internal',
                'full_name' => '2nd Field Artillery Battalion',
                'parent_organization_id' => 332,
            ],
            336 => [
                'organization_type' => 'internal',
                'full_name' => '3rd Field Artillery Battalion',
                'parent_organization_id' => 332,
            ],
            337 => [
                'organization_type' => 'internal',
                'full_name' => '4th Field Artillery Battalion',
                'parent_organization_id' => 332,
            ],
            338 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Nurse Corps',
                'parent_organization_id' => NULL,
            ],
            339 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Nurse Corps Headquarters and Headquarters Service Battalion',
                'parent_organization_id' => 338,
            ],
            340 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Nurse Corps Training and Doctrine Center',
                'parent_organization_id' => 338,
            ],
            341 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Nurse Corps Recruitment and Retention Office',
                'parent_organization_id' => 338,
            ],
            342 => [
                'organization_type' => 'internal',
                'full_name' => 'Army Nurse Corps Reserve Component',
                'parent_organization_id' => 338,
            ],
            343 => [
                'organization_type' => 'internal',
                'full_name' => NULL,
                'parent_organization_id' => 338,
            ],
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
