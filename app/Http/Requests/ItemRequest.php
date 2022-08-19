<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'itemcode' => ['required'],
            'description' => ['required']

        ];
    }
    public function messages()
    {
        return [
            'itemcode.required' => 'Item Code must no be empty',
            'description.required' => 'Item Description must not be empty'
        ];
    }
}
