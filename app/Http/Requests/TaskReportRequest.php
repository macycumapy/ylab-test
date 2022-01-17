<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskReportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_start' => ['sometimes', 'date_format:Y-m-d'],
            'date_finish' => ['sometimes', 'date_format:Y-m-d'],
            'is_confirmed' => ['sometimes', 'boolean'],
            'user_id' => ['sometimes', 'integer'],
        ];
    }
}
