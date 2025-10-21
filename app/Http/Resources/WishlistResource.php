<?php

namespace App\Http\Resources;

use App\Http\Resources\WishlistItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'items'=>WishlistItemResource::collection($this->whenLoaded('wishlistItems')),
        ];
    }
}
