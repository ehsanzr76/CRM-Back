<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'name'=>'required|string|unique:employees|max:255',
            'email'=>'required|string|unique:employees|max:255',
            'phone'=>'required|starts_with:9|digits:10|unique:employees',
            'address'=>'required|string',
            'salary'=>'required|numeric',
            'nid'=>'required|numeric|unique:employees',
            'joining_date'=>'required',
            'photo'=>'nullable|string'
        ];
    }
}
