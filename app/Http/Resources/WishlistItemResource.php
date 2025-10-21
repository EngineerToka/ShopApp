<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistItemResource extends JsonResource
{

    public function toArray($request)
    {
       return [
            'id'=>$this->id,
            'product'=> new ProductResource($this->whenLoaded('product')),
            'added_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
