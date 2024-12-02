<?php

namespace App\Http\Resources\app\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, 
            'user_id' => $this->user_id, // 
            'subscription_id' => $this->subscription_id, 
            'amount_paid' => $this->amount_paid, // 
             'payment_method' => $this->payment_method, // 
            'created_at' => $this->created_at->toDateTimeString(), 
            'updated_at' => $this->updated_at->toDateTimeString(),
            'payment_date' => $this->payment_date
        ];
    }
}
