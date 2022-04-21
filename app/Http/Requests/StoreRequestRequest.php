<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'content' => ['required'],
            'priority_id' => ['required', 'exists:priorities,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'assignee_id' => ['required', 'exists:users,id'],
            // 'status' => ['required'],
            'due_date' => ['required', 'date', 'after:yesterday'],
        ];
    }
}
