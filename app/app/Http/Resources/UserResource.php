<?php

namespace App\Http\Resources;

use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
//        self::withoutWrapping();

        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'posts' => PostResource::collection($this->whenLoaded('posts')),
        ];
    }
}