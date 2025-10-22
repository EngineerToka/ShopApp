<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateOrderStatusRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled'
        ];
    }
}
