<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BURequest extends FormRequest
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
            'bu_name' => ['required'],
            'bu_code' => ['required'],
            'bu_type' => ['required'],
            'bu_server' => ['required'],
            'bu_seq_code' => ['required']

        ];
    }
    public function messages()
    {
        return [
            'bu_name.required' => 'Business unit name must not be empty.',
            'bu_code.unique' => 'Business unit code must unique.',
            'bu_code.required' => 'Business unit code must not be empty.',
            'bu_type.required' => 'Please select a type to proceed.',
            'bu_server.required' => 'Business unit server must not be empty',
            'bu_seq_code.required' => 'Sequence code must not be empty',
        ];
    }
}
