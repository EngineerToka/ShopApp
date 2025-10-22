<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReviewRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
             'product_id' => 'required|exists:products,id',
             'rating'  => 'required|integer|min:1|max:5',
             'comment' => 'nullable|string|max:2000',
        ];
    }
}
