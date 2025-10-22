<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $copounId = $this->route('copoun');

        return [
            'code'       => 'required|string|unique:coupons,code,' . $copounId,
            'type'       => 'required|in:fixed,percent',
            'value'      => 'required|numeric|min:1',
            'min_order'  => 'nullable|numeric|min:0',
            'max_uses'   => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:today',
            'active'     => 'boolean',
        ];
    }
}
