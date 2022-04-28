<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImageUploadRequest extends FormRequest
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
            'file' => [
                'required',
                'file',
                config('images.rule')
            ],
            'entity' => [
                'required',
                'string',
                Rule::in(config('images.entity'))
            ],
            'entity_id' => [
                'required',
                // todo: exist in specific table
            ]
        ];
    }
}
