<?php

namespace App\Http\Requests\app\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'subscription_id' => 'nullable|exists:subscriptions,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:credit_card,paypal,cash',
        ];
    }
}