<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId= $this->route('user')?$this->route('user')->id : null;
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$userId, // Exclude current user from unique check on update
            'password' => $userId?  'sometimes|string|min:6|confirmed' : 'required|string|min:6|confirmed',
            'phone' => 'sometimes|string|max:20',
            'adress' => 'sometimes|string',
            'role' =>'required|in:admin,customer,seller',
            'status' => 'sometimes|boolean',
            'profile_image' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
