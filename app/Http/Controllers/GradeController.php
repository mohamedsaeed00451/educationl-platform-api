<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Grade;

class GradeController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::all();
        return $this->responseMessage(200, true, null, $grades);
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
    public function store(GradeRequest $request)
    {
        try {
            $grade = Grade::create([
                'grade' => $request->grade
            ]);
            return $this->responseMessage(201, true, null, $grade);
        } catch (\Exception $e) {
            return $this->responseMessage(400, false,'حدث خطأ ما');
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
    public function update(GradeRequest $request,$id)
    {
        try {
            $grade = Grade::find($id);
            if (!$grade)
                return $this->responseMessage(400, false);
            $grade->update([
                'grade' => $request->grade
            ]);
            return $this->responseMessage(201, true, null, $grade);
        } catch (\Exception $e) {
            return $this->responseMessage(400, false,'حدث خطأ ما');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $grade = Grade::find($id);
            if (!$grade)
                return $this->responseMessage(400, false);
            $grade->delete();
            return $this->responseMessage(200, true, 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            return $this->responseMessage(400, false,'حدث خطأ ما');
        }
    }
}
