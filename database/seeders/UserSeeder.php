<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        $user = [
            'name' => 'student',
            'username' => 'student123',
            'password' => Hash::make(12345678),
            'student_phone' => '01010101010',
            'father_phone' => '01020202020',
            'address' => 'student address',
            'gender_id' => Gender::all()->random()->id,
            'grade_id' => Grade::all()->random()->id,
            'class_room_id' => ClassRoom::all()->random()->id,
            'section_id' => Section::all()->random()->id,
        ];

        User::create($user);
    }
}
