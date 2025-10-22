<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class stockMangementRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() && auth()->user()->isAdmin(); // Only allow if the user is authenticated and is an admin
    }


    public function rules()
    {
        return [
            'quantity' => 'required|integer|min:0',
        ];
    }
}
