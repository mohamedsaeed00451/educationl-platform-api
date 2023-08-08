<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Section;

class SectionController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        return $this->responseMessage(200, true, null, $sections);
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
    public function store(SectionRequest $request)
    {
        try {
            $section = Section::create([
                'section' => $request->section,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);
            return $this->responseMessage(201, true, null, $section);
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
    public function update(SectionRequest $request, $id)
    {
        try {
            $section = Section::find($id);
            if (!$section)
                return $this->responseMessage(400, false);
            $section->update([
                'section' => $request->section,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);
            return $this->responseMessage(201, true, null, $section);
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
            $section = Section::find($id);
            if (!$section)
                return $this->responseMessage(400, false);
            $section->delete();
            return $this->responseMessage(200, true, 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }
}
