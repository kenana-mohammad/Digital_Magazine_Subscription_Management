<?php

namespace App\Http\Resources\common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
    'magazine' => [
        'id' => $this->magazine->id, 
        'name' => $this->magazine->name, // 
    ],
    'user' => [
        'id' => $this->user->id, 
        'name' => $this->user->name, 
    ],
    'start_date' => $this->start_date,
    'end_date' => $this->end_date, //
    'status' => $this->status, 
        ];
    }
}
