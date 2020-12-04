<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'book_id' => $this->book_id,
            'bookTitle' => $this->book->title,
            'category_id' => $this->category_id,
            'categoryName' => $this->category->name,
        ];
    }
}
