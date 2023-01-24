<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name'=>'required|max:255',
            'buying_price'=>'nullable',
            'selling_price'=>'required',
            'quantity'=>'required',
            'buying_date'=>'nullable',
            'product_code'=>'nullable',
            'root'=>'nullable',
            'photo'=>'nullable',
            'category_id'=>'required',
            'supplier_id'=>'required',
        ];
    }
}
