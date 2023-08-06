<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('grades')->delete();
        $grades = [
            ['grade' => 'المرحلة الابتدائية'],
            ['grade' => 'المرحلة الاعدادية'],
            ['grade' => 'المرحلة الثانوية'],
        ];

        foreach ($grades as $grade) {
            Grade::create($grade);
        }
    }
}
