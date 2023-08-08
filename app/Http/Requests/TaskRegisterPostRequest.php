<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Task as TaskModel;

class TaskRegisterPostRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:128'],
            'period' => ['required', 'date', 'after_or_equal:today'],
            'detail' => ['max:65535'],
            'priority' => ['required', 'numeric', Rule::in( array_keys(TaskModel::PRIORITY_VALUE) ) ],
        ];
    }
}
