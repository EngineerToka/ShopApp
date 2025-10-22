<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'coupon_code' => 'nullable|string|exists:coupons,code',
        ];
    }
}
