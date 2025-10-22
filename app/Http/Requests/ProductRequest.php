<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function authorize()
    {
       return true; 
    }


    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'category_id'=>'required|exists:categories,id',
            'status'=>'boolean',
        ];
    }

  
    //  public function messages()
    // {
    //     return [
    //         '' => '',

    //     ];
    // }
}
