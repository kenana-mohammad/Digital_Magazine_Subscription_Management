<?php

namespace App\Http\Resources\Common\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
             'title' => $this->title,
             'content' => $this->content,
             'magazine' => $this->magazine->id,
             'publication_date'=> $this->publication_date,
             'created_at' => ($this->created_at)->toDateString()

        ];
    }
}
