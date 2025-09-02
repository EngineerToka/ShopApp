<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id'             => $this->id,
            'title'          => $this->title,
            'description'    => $this->description,
            'quantity'       => $this->quantity,
            'price'          => $this->price,
            'discount_price' => $this->discount_price,
            'status'         => (bool) $this->status,
            'main_image'     => $this->main_image, 
            'images'         => ProductImageResource::collection($this->whenLoaded('images')),
            'category'       => new CategoryResource($this->whenLoaded('category')),
            'user'           => new UserResource($this->whenLoaded('user')),
            'created_at'     => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'     => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
