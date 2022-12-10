<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SaleStoreRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => 1,
            'invoice_no' => '1001',
        ]);
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|integer|exists:customers,id',
            'user_id' => 'required|integer|exists:users,id',
            'payment_method_id' => 'required|integer|in:1,2',
            'invoice_no' => 'required|string',
            'total_quantities' => 'required|integer',
            'sub_total' => 'required|numeric',
            'vat' => 'required|numeric',
            'grand_total' =>  'required|numeric',
            'pay' => 'nullable|numeric',
            'due' => 'nullable|numeric'
        ];
    }
}
