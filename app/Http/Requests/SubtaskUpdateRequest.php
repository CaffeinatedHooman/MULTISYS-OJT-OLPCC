<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubtaskUpdateRequest extends FormRequest
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
            'title.max' => 'Title limit has been reached.',
            'completed.in' => 'Put 1 if the task has been completed, if not put 0',
        ];
    }
    
}
