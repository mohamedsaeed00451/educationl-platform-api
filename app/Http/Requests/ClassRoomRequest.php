<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRoomRequest extends FormRequest
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
            'class_room' => 'bail|required|string|unique:class_rooms,class_room',
            'price' => 'bail|nullable|numeric',
            'start_date' => 'bail|nullable|date|date_format:Y-m-d|after_or_equal:' . date('Y-m-d') . ''
        ];
    }

    public function onUpdate()
    {
        $id = request()->segment(count(request()->segments()));
        return [
            'class_room' => 'bail|required|string|unique:class_rooms,class_room,' . $id,
            'price' => 'bail|nullable|numeric',
            'start_date' => 'bail|nullable|date|date_format:Y-m-d|after_or_equal:' . date('Y-m-d') . ''
        ];
    }
}
