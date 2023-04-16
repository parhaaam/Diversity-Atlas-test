<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"        => $this->id,
            "publisher" => $this->publisher,
            "title"     => $this->title,
            "summary"   => $this->summary,
            "authors"   => $this->authors->map(fn ($author) => $author->name)
        ];
    }
}
