<?php

namespace App\Http\Requests;

class StorePostRequest extends BaseFormRequest
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
        return [
            // bail Rule on title : If required fails (e.g., the title is missing), Laravel will not check unique:posts or max:255
            'title' => 'bail|required|unique:posts|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
