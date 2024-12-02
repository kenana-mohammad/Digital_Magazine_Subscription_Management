<?php

namespace App\Http\Requests\app\Article;

use Illuminate\Foundation\Http\FormRequest;

class AddCommentRequest extends FormRequest
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
            //

            'content' => 'required|string|max:20000',
            'article_id' => 'exists:articles,id',
            'user_id' => 'exists:users,id',
            'comment_date' => 'data',
        ];
    }
}
