<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $copounId = $this->route('copoun');

        return [
            'code'       => 'required|string|unique:coupons,code,' . $couponId,
            'type'       => 'required|in:fixed,percent',
            'value'      => 'required|numeric|min:1',
            'min_order'  => 'nullable|numeric|min:0',
            'max_uses'   => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:today',
            'active'     => 'boolean',
        ];
    }
}
