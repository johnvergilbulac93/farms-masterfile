<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NonTradeCustomerRequest extends FormRequest
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
            'nav_code' => ['required'],
            'cus_name' => ['required'],
            'bu_code' => ['required']


        ];
    }
    public function messages()
    {
        return [
            'nav_code.required' => 'Navision code must no be empty.',
            'cus_name.required' => 'Customer name must not be empty.',
            'bu_code.required' => 'Please select a business unit.'
        ];
    }
}
