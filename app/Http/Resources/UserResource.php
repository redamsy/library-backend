<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->client) {
            $userType = 'CLIENT';
        }
        if($this->admin) {
            $userType = 'ADMIN';
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'userType' => $userType,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
