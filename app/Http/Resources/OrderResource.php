<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status'   => $this->status,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'total'    => $this->total,
            'coupon'    => $this->whenLoaded('coupon', function () {
                return [
                    'code'   => $this->coupon->code,
                    'type'   => $this->coupon->type,
                    'value'  => $this->coupon->value,
                ];
            }),
            'items'    => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'user'     => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
