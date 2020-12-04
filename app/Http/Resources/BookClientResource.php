<?php

namespace App\Http\Resources;
use App\Book;
use App\Http\Resources\BookResource;

use Illuminate\Http\Resources\Json\JsonResource;

class BookClientResource extends JsonResource
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
            'clientName' => $this->client->user->name,
            'clientEmail' => $this->client->user->email,
            'clientPhoneNumber' => $this->client->phoneNumber,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'book_id' => $this->book->id,
            'bookTitle' => $this->book->title,
        ];
    }
}
