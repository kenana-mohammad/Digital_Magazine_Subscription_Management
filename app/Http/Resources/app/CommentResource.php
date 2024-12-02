<?php

namespace App\Http\Resources\app;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'user' => $this->user->id,
            'user-name' => $this->user->name,
            'content' => $this->content,
            'article' => $this->article,
            'comment_date' => $this->comment_date
        ];
    }
}
