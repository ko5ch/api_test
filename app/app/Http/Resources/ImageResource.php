<?php

namespace App\Http\Resources;

use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'id'    => $this->id,
            'url'   => $this->url,
        ];
    }
}