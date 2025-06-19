<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'book_url' => $this->book_url,
            'publisher' => $this->publisher,
            'publication_year' => $this->publication_year,
            'isbn' => $this->isbn,
            'genre' => $this->genre,
            'status' => $this->status,
            'pages' => $this->pages,
            'price' => $this->price,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}