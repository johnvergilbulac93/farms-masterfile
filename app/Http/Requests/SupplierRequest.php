<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'sup_code' => ['required'],
            'sup_name' => ['required'],
            'sup_addr' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'sup_code.required' => 'Supplier code must not be empty.',
            'sup_name.required' => 'Supplier name must not be empty.',
            'sup_addr.required' => 'Supplier address must not be empty.'
        ];
    }
}
