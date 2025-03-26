<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $postId = $this->route('post')->id;

        return [
            // Title is required, unique except for the current post
            'title' => [
                'bail',
                'required',
                Rule::unique('posts')->ignore($postId),
                'max:255'
            ],
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB max
        ];
    }

    /**
     * displaying category id is required istead of category_id.
     */

    public function attributes(): array
    {
        return [
            'category_id' => 'category id',
        ];
    }
}
