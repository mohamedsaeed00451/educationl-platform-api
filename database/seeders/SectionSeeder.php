<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sections')->delete();

        $Sections = [
            ['section' => 'ا', 'student_number' => 300, 'start_time' => date('H:i:s'), 'end_time' => date('H:i:s')],
            ['section' => 'ب', 'student_number' => 250, 'start_time' => date('H:i:s'), 'end_time' => date('H:i:s')],
            ['section' => 'ت', 'student_number' => 400, 'start_time' => date('H:i:s'), 'end_time' => date('H:i:s')],
        ];

        foreach ($Sections as $section) {
            Section::create($section);
        }
    }
}
