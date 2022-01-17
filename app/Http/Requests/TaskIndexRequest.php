<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort_by' => ['nullable', 'string'],
            'sort_direction' => ['nullable', 'string', 'in:asc,desc'],
            'page' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer'],
        ];
    }

    public function filters(): array
    {
        return collect($this->all())->except([
            'page',
            'per_page',
            'sort_by',
            'sort_direction',
        ])->toArray();
    }
}
