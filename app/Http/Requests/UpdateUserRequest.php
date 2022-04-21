<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
            'email' => ['email', 'unique:users,email,'.$this->user->id],
            // 'password' => ['required', 'min:8'],
            'code_login' => ['unique:users,code_login,'.$this->user->id],
            'google_token' => ['unique:users,google_token,'.$this->user->id],
            'role_id' => ['required','exists:roles,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'position_id' => ['required', 'exists:positions,id'],
            'status' => [],
            // 'avatar' => ['image','mimes:jpeg,png,jpg','max:2048']
        ];
    }
}
