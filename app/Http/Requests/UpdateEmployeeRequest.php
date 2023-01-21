<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255',
            'phone'=>'required|starts_with:9|digits:10',
            'address'=>'required|string',
            'salary'=>'required|numeric',
            'nid'=>'required|numeric',
            'joining_date'=>'required',
            'photo'=>'nullable|string'
        ];
    }
}
