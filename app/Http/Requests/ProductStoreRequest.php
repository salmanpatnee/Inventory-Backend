<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'category_id' => 'required|integer|exists:categories,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'name' => 'required|string|max:255|unique:products,name',
            'code' => 'nullable|string|max:255|unique:products,code',
            'root' => 'nullable|string|max:255',
            'cost' => 'nullable|numeric',
            'price' => 'nullable|required_with:cost|gt:cost',
            'quantity' => 'nullable|numeric',
            'alert_quantity' => 'nullable|numeric',
            'purchase_date' => 'nullable|date'
        ];
    }
}
