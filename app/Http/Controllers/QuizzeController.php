<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizzeRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Quizze;

class QuizzeController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quizze::with('grade', 'classRoom')->paginate(PAGINATION_NUMBER);
        return $this->responseMessage(200, true, null, $quizzes);
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
    public function store(QuizzeRequest $request)
    {
        try {
            $quizze = Quizze::create([
                'title' => $request->title,
                'grade_id' => $request->grade_id,
                'class_room_id' => $request->class_room_id,
            ]);
            return $this->responseMessage(201, true, null, $quizze);
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
    public function update(QuizzeRequest $request,$id)
    {
        try {
            $quizze = Quizze::find($id);
            if (!$quizze)
                return $this->responseMessage(400, false);
            $quizze->update([
                'title' => $request->title,
                'grade_id' => $request->grade_id,
                'class_room_id' => $request->class_room_id,
            ]);
            return $this->responseMessage(201, true, null, $quizze);
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
            $quizze = Quizze::find($id);
            if (!$quizze)
                return $this->responseMessage(400, false);
            $quizze->delete();
            return $this->responseMessage(200, true, 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }

    public function getQuizzeQuestions($id)
    {
        $quizze = Quizze::find($id);
        if (!$quizze)
            return $this->responseMessage(400, false);
        foreach ($quizze->questions as $question) {
            $question->answers = json_decode($question->answers);
        }
        return $this->responseMessage(200, true, null, $quizze);
    }

    public function getQuizzeAnswersStudents($id)
    {
        $quizze = Quizze::find($id);
        if (!$quizze)
            return $this->responseMessage(400, false);

        $quizze->student_count = $quizze->degrees()->count();
        $total_score = 0;
        foreach ($quizze->questions as $question) {
            $total_score += $question->score;
        }
        $quizze->quizze_score = $total_score;
        $students = [];
        foreach ($quizze->degrees as $degree) {
            $students[] = [
                'id' => $degree->student->id,
                'name' => $degree->student->name,
                'score' => $degree->score
            ];
        }
        $quizze->students = $students;
        unset($quizze->degrees);
        unset($quizze->questions);
        return $this->responseMessage(200, true, null, $quizze);
    }
}
