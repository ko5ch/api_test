<?php

namespace App\Http\Resources\QueryBuilder;

use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentBuildedResource extends JsonResource
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
            'id'            => $this->id,
            'content'       => $this->content,
            'post'          => optional($this)->post ? PostBuildedResource::collection($this->post) : null,
        ];
    }
}