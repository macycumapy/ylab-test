<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_start' => ['required', 'date'],
            'date_finish' => ['required', 'date'],
            'name' => ['required', 'string'],
            'project' => ['required', 'string'],
            'user_id' => ['required', 'integer'],
        ];
    }
}
