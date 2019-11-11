<?php

namespace App\Http\Resources\QueryBuilder;

use App\Image;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class PostBuildedResource extends JsonResource
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
            'image_url'         => $this->url,
            'author'            => optional(optional($this->author)[0])->active ? $this->author : null,
        ];
    }
}