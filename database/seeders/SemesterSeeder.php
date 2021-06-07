<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('semesters')->insert([
            [
                'semester' => 'First Semester',
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'semester' => 'Second Semester',
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'semester' => 'Third Semester',
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
