<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ?
            $this->onUpdate() : $this->onCreate();
    }

    public function onCreate()
    {
        return [
            'title' => 'bail|required|string|max:200|unique:quizzes,title',
            'answers' => 'bail|required|array',
            'answers.*' => 'bail|required|string',
            'right_answer' => 'bail|required|string',
            'score' => 'bail|required|numeric',
            'quizze_id' => 'bail|required|exists:quizzes,id',
        ];
    }

    public function onUpdate()
    {
        $id = request()->segment(count(request()->segments()));
        return [
            'title' => 'bail|required|string|max:200|unique:quizzes,title,' . $id,
            'answers' => 'bail|required|array',
            'answers.*' => 'bail|required|string',
            'right_answer' => 'bail|required|string',
            'score' => 'bail|required|numeric',
            'quizze_id' => 'bail|required|exists:quizzes,id',
        ];
    }
}
