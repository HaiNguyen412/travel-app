<?php

namespace App\Http\Requests\Common\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogCreateRequest extends FormRequest
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
            'status' => [],
            'author_id' => [],
            'like_total' => [],
            'dislike_total' => [],
            'comment_total' => [],
        ];
    }
}
