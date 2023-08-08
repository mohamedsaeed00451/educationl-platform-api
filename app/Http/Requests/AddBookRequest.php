<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBookRequest extends FormRequest
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
        return [
            'title' => 'bail|required|string|max:200|unique:libraries,title',
            'grade_id' => 'bail|required|exists:grades,id',
            'class_room_id' => 'bail|required|exists:class_rooms,id',
            'book' => 'bail|required|file|mimes:pdf,txt,docx,xlsx',
        ];
    }

}
