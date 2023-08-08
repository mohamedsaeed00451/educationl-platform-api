<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
            'section' => 'bail|required|string|unique:sections,section',
            'start_time' => 'bail|required|date_format:H:i|before:end_time',
            'end_time' => 'bail|required|date_format:H:i|after:start_time',
        ];
    }

    public function onUpdate()
    {
        $id = request()->segment(count(request()->segments()));
        return [
            'section' => 'bail|required|string|unique:sections,section,' . $id,
            'start_time' => 'bail|required|date_format:H:i|before:end_time',
            'end_time' => 'bail|required|date_format:H:i|after:start_time',
        ];
    }
}
