<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class stockMangementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->isAdmin(); // Only allow if the user is authenticated and is an admin
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'required|integer|min:0',
        ];
    }
}
