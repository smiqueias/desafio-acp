<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required',
            'code' => 'required',
            'category' => [
                'required',
                Rule::in(['categoria 1','categoria 2','categoria 3'])
            ],
            'status' => [
                'required',
                Rule::in(['sem estoque','em estoque'])
            ]
        ];
    }
}
