<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        return [
            "id" => $this->id,
            "author" => $this->author,
            "category" => $this->category,
            "description" => $this->description,
            "publish_date" => Carbon::parse($this->date)->diffForHumans(),
            "source" => $this->source,
            "thumbnail" => $this->image,
            "title" => $this->title,
            "url" => $this->url
        ];
    }
}
