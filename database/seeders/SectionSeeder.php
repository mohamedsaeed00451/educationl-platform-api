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
            ['section' => 'ا',  'start_time' => date('H:i:s'), 'end_time' => date('H:i:s')],
            ['section' => 'ب',  'start_time' => date('H:i:s'), 'end_time' => date('H:i:s')],
            ['section' => 'ت',  'start_time' => date('H:i:s'), 'end_time' => date('H:i:s')],
        ];

        foreach ($Sections as $section) {
            Section::create($section);
        }
    }
}
