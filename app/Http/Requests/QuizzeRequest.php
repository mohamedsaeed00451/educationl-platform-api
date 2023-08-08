<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizzeRequest extends FormRequest
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
            'grade_id' => 'bail|required|exists:grades,id',
            'class_room_id' => 'bail|required|exists:class_rooms,id',
        ];
    }

    public function onUpdate()
    {
        $id = request()->segment(count(request()->segments()));
        return [
            'title' => 'bail|required|string|max:200|unique:quizzes,title,' . $id,
            'grade_id' => 'bail|required|exists:grades,id',
            'class_room_id' => 'bail|required|exists:class_rooms,id',
        ];
    }
}
