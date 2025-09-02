<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
         return [
            'id'        => $this->id,
            'rating'    => (int) $this->rating,
            'comment'   => $this->comment,
            'user'      => new UserResource($this->whenLoaded('user')),
            'product'      => new ProductResource($this->whenLoaded('product')),
            'created_at'=> $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
