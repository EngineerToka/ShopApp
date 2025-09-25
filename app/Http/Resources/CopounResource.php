<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CopounResource extends JsonResource
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
            'id'         => $this->id,
            'code'       => $this->code,
            'type'       => $this->type,
            'value'      => $this->value,
            'min_order'  => $this->min_order,
            'max_uses'   => $this->max_uses,
            'used_count' => $this->used_count,
            'active'     => $this->active,
            'expires_at' => $this->expires_at,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
