<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|min:4|max:20',
            'description' => 'required|string|min:4|max:255',
            'completed' => 'required|in:0,1',
        ];
    }
    public function messages()
    {
        return [
            'title.string' => 'The field is empty',
            'title.min' => 'Minimum of 4 characters',
            'title.max' => 'Title limit has been reached.',
            'description.string' => 'The field is empty',
            'decription.min' => 'Minimum of 4 characters',
            'description.max' => 'Description limit has been reached',
            'completed.required' => 'Put 1 if the task has been completed, if not put 0',
            'completed.in' => 'Put 1 if the task has been completed, if not put 0',

        ];
    }
}
