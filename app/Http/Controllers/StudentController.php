<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::with('grade','classRoom','section')->paginate(PAGINATION_NUMBER);
        foreach ($students as $student) {
            $student->student_gender = $student->gender->gender;
            unset($student->gender);
        }
        return $this->responseMessage(200, true, null, $students);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        try {
            $username = Str::random(10); //Create Unique UserName
            $password = random_int(10000000,99999999);
            $existinguserName = User::pluck('username')->toArray();
            while (in_array($username, $existinguserName)) {
                $username = Str::random(10);
            }
            $student = User::create([
                'name' => $request->name,
                'username' => $username,
                'password' => Hash::make($password),
                'student_password' => $password,
                'student_phone' => $request->student_phone,
                'father_phone' => $request->father_phone,
                'address' => $request->address,
                'gender_id' => $request->gender_id,
                'grade_id' => $request->grade_id,
                'class_room_id' => $request->class_room_id,
                'section_id' => $request->section_id,
            ]);
            $student->student_gender = $student->gender->gender;
            unset($student->gender);
            return $this->responseMessage(201, true, null, $student);
        } catch (\Exception $e) {
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request,$id)
    {
        try {
            $student = User::find($id);
            if (!$student)
                return $this->responseMessage(400, false);
            $student->update([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'student_password' => $request->password,
                'student_phone' => $request->student_phone,
                'father_phone' => $request->father_phone,
                'address' => $request->address,
                'gender_id' => $request->gender_id,
                'grade_id' => $request->grade_id,
                'class_room_id' => $request->class_room_id,
                'section_id' => $request->section_id,
            ]);

            $student->student_gender = $student->gender->gender;
            unset($student->gender);
            return $this->responseMessage(201, true, null, $student);
        } catch (\Exception $e) {
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $student = User::find($id);
            if (!$student)
                return $this->responseMessage(400, false);
            $student->delete();
            return $this->responseMessage(200, true, 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }
}
