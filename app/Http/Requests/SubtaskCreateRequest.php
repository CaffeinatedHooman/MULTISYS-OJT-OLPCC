<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubtaskCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'min:4|max:255',
            'completed' => 'boolean|in:0,1',
        ];
    }

    public function messages()
    {
        return [
            'title.min' => 'Above 4 characters',
            'title.max' => 'It should be less than 255 characters',
            'completed.in' => 'Put 1 if the task has been completed, if not put 0',
        ];
    }
}
