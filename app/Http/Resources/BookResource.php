<?php

namespace App\Http\Resources;

use App\Http\Resources\AuthorResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PublisherResource;
use App\Http\Resources\SerieResource;
use App\Http\Resources\LanguageResource;
use App\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   $pdfName = "";
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $pdfName = $this->pdfName;
        }
        return [
            'id' => $this->id,
            'publisher' => new PublisherResource($this->publisher),
            'serie' => new SerieResource($this->serie),
            'language' => new LanguageResource($this->language),
            'title' => $this->title,
            'description' => $this->description,
            'publishDate' => $this->publishDate,
            'price' => $this->price,
            'chapters' => $this->chapters,
            'pages' => $this->pages,
            'isProhibited' => $this->isProhibited,
            'imageName' => $this->imageName,
            'pdfName' => $pdfName,
            'downloads' => $this->clients->count(),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'authors' => AuthorResource::collection($this->authors),
            'categories' => CategoryResource::collection($this->categories),
        ];
    }
}
