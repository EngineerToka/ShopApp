<?php

namespace App\Http\Resources;

use App\Http\Resources\CopounResource;
use App\Http\Resources\CartItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
   
    public function toArray($request)
    {

        return[
            'id'        => $this->id,
            'user_id'   => $this->user_id,
            'coupon'    => new CopounResource($this->whenLoaded('coupon')),
            'items'     => CartItemResource::collection($this->whenLoaded('items')),
            'created_at'=> $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'=> $this->updated_at->format('Y-m-d H:i:s'),           
        ];

    }
}
