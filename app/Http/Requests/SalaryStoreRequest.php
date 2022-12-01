<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;

class SalaryStoreRequest extends FormRequest
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
            'employee_id' => 'required|integer|exists:employees,id',
            'amount' => 'required|numeric',
            'paid_date' => 'required|date',
            'month' =>  [
                'required', 'string',
                Rule::unique('salaries')
                    ->where('employee_id', $this->employee_id)
            ], 
            'year' =>  'required|numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'month.unique' => 'Salary has already paid for selected month.',
        ];
    }
}
