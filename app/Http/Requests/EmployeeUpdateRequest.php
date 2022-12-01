<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email,' . $this->id,
            'phone' => 'nullable|string|unique:employees,phone,' . $this->id,
            'address' => 'nullable|string',
            'salary' => 'nullable|numeric',
            'joining_date'  => 'nullable|date'
        ];
    }
}