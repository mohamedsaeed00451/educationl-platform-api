<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'name' => 'bail|required|string|max:100',
            'student_phone' => 'bail|required|regex:/^[0-9]\d{10}$/|unique:users,student_phone',
            'father_phone' => 'bail|required|regex:/^[0-9]\d{10}$/|unique:users,father_phone',
            'address' => 'bail|nullable|string|max:200',
            'gender_id' => 'bail|required|exists:genders,id',
            'grade_id' => 'bail|required|exists:grades,id',
            'class_room_id' => 'bail|required|exists:class_rooms,id',
            'section_id' => 'bail|required|exists:sections,id',
        ];
    }

    public function onUpdate()
    {
        $id = request()->segment(count(request()->segments()));
        return [
            'name' => 'bail|required|string|max:100',
            'password' => 'bail|required|string|min:8',
            'student_phone' => 'bail|required|regex:/^[0-9]\d{10}$/|unique:users,student_phone,' . $id,
            'father_phone' => 'bail|required|regex:/^[0-9]\d{10}$/|unique:users,father_phone,' . $id,
            'address' => 'bail|nullable|string|max:200',
            'gender_id' => 'bail|required|exists:genders,id',
            'grade_id' => 'bail|required|exists:grades,id',
            'class_room_id' => 'bail|required|exists:class_rooms,id',
            'section_id' => 'bail|required|exists:sections,id',
        ];
    }
}
