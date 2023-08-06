<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genders')->delete();
        $genders = [
            ['gender' => 'ذكر'],
            ['gender' => 'انثي'],
        ];
        foreach ($genders as $gender) {
            Gender::create($gender);
        }
    }
}
