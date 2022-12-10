<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'      => 'required|string|min:3|max:255',
            'email'     => 'required|email|max:255|unique:users,email,'.$this->id,
            'password'  => 'sometimes|min:6|max:255|confirmed',
            'phone'     => 'nullable|numeric|unique:users,phone,'.$this->id,
            'address'   => 'nullable|string',
            'salary'    => 'nullable|numeric',
            'joining_date'  => 'nullable|date', 
            'active'  => 'nullable|boolean'
        ];
    }
}
