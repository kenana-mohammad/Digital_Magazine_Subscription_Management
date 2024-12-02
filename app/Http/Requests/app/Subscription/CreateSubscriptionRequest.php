<?php

namespace App\Http\Requests\app\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriptionRequest extends FormRequest
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
            'magazine_id'=> 'nullable|exists:magazines,id',
            'status' => 'nullable|in:pending,active, concluded',
            'end_date' => 'date|after:today:'
        ];
    }
}
