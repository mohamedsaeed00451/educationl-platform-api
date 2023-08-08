<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Question;

class QuestionController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(QuestionRequest $request)
    {
        try {
            $question = Question::create([
                'title' => $request->title,
                'answers' => json_encode($request->answers),
                'right_answer' => $request->right_answer,
                'score' => $request->score,
                'quizze_id' => $request->quizze_id,
            ]);
            $question->answers = json_decode($question->answers);
            return $this->responseMessage(201, true, null, $question);
        } catch (\Exception $e) {
            return $this->responseMessage(400, false, 'حدث خطأ ما',$e->getMessage());
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
    public function update(QuestionRequest $request, $id)
    {
        try {
            $question = Question::find($id);
            if (!$question)
                return $this->responseMessage(400, false);
            $question->update([
                'title' => $request->title,
                'answers' => json_encode($request->answers),
                'right_answer' => $request->right_answer,
                'score' => $request->score,
                'quizze_id' => $request->quizze_id,
            ]);
            $question->answers = json_decode($question->answers);
            return $this->responseMessage(201, true, null, $question);
        } catch (\Exception $e) {
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $question = Question::find($id);
            if (!$question)
                return $this->responseMessage(400, false);
            $question->delete();
            return $this->responseMessage(200, true, 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }
}
