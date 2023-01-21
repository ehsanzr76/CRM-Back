<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'name'=>'required|string|unique:suppliers|max:255',
            'email'=>'required|string|unique:suppliers,email|max:255',
            'phone'=>'required|starts_with:9|digits:10|unique:suppliers',
            'address'=>'required|string',
            'shop_name'=>'nullable|string',
            'photo'=>'nullable|string'
        ];
    }
}
