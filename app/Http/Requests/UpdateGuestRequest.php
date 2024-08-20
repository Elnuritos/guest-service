<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuestRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route('guest');

        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:guests,email,'.$id,
            'phone' => 'sometimes|required|string|unique:guests,phone,'.$id,
            'country' => 'nullable|string|max:255',
        ];
    }
}
