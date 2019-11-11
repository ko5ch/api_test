<?php

namespace App\Http\Resources;

use App\Image;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    use Authorizable;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        self::withoutWrapping();

        return [
            'id'                => $this->id,
            'content'           => $this->content,
            'created_at'        => $this->created_at,
            'image_url'         => $this->image_url,
            'count_of_comments' => $this->count_of_comments,  // 6.2
            'author'            => $this->whenLoaded('author', function() { //: 7.2.1***
                return $this->author->active ? $this->author : null;
            })
        ];
    }
}