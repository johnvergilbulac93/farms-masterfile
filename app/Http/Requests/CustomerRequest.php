<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'cus_name' => ['required'],
            'cus_code' => ['required'],
            'cus_type' => ['required'],

        ];
    }
    public function messages()
    {
        return [
            'cus_name.required' => 'Customer name must not be empty.',
            'cus_code.required' => 'Customer code must not be empty.',
            'cus_type.required' => 'Please select a customer type to proceed.',
        ];
    }
}
