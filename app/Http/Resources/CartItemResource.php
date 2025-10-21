<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{

    public function toArray($request)
    {
        return[
            'id'        => $this->id,
            'product'   => new ProductResource($this->whenLoaded('product')),
            'quantity'    => $this->quantity,
            'total_price'=> $this->product->price * $this->quantity,
        ];
    }
}
