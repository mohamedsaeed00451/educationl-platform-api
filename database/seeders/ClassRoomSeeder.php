<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('class_rooms')->delete();

        $classrooms = [
            ['class_room' => 'الصف الاول', 'price' => 100, 'start_date' => date('Y-m-d')],
            ['class_room' => 'الصف الثاني', 'price' => 200, 'start_date' => date('Y-m-d')],
            ['class_room' => 'الصف الثالث', 'price' => 300, 'start_date' => date('Y-m-d')],
        ];

        foreach ($classrooms as $classroom) {
            Classroom::create($classroom);
        }
    }
}
