<?php

namespace App\Http\Resources;

use App\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phoneNumber' => $this->phoneNumber,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'books' => BookResource::collection($this->books),
        ];
    }
}
