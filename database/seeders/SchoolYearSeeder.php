<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_years')->insert([
            [
                'school_year' => '2021-2022',
                'status'     => '0',
            ],
            [
                'school_year' => '2022-2023',
                'status'     => '0',
            ],
            [
                'school_year' => '2023-2024',
                'status'     => '0',
            ],
            [
                'school_year' => '2024-2025',
                'status'     => '0',
            ],
            [
                'school_year' => '2025-2026',
                'status'     => '0',
            ],
            [
                'school_year' => '2026-2027',
                'status'     => '0',
            ],
            [
                'school_year' => '2027-2028',
                'status'     => '0',
            ],
            [
                'school_year' => '2028-2029',
                'status'     => '0',
            ],
            [
                'school_year' => '2029-2030',
                'status'     => '0',
            ],
        ]);
    }
}
