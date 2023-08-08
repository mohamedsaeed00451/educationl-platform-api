<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassRoomRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\ClassRoom;

class ClassRoomController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = ClassRoom::all();
        return $this->responseMessage(200, true, null, $classrooms);
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
    public function store(ClassRoomRequest $request)
    {
        try {
            $classroom = ClassRoom::create([
                'class_room' => $request->class_room,
                'price' => $request->price,
                'start_date' => $request->start_date,
            ]);
            return $this->responseMessage(201, true, null, $classroom);
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
    public function update(ClassRoomRequest $request, $id)
    {
        try {
            $classroom = ClassRoom::find($id);
            if (!$classroom)
                return $this->responseMessage(400, false);
            $classroom->update([
                'class_room' => $request->class_room,
                'price' => $request->price,
                'start_date' => $request->start_date,
            ]);
            return $this->responseMessage(201, true, null, $classroom);
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
            $classroom = ClassRoom::find($id);
            if (!$classroom)
                return $this->responseMessage(400, false);
            $classroom->delete();
            return $this->responseMessage(200, true, 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }
}
