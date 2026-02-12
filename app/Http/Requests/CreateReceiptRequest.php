<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReceiptRequest extends FormRequest
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
            'contract'=>['required'],

        ];
    }

    public function messages()
    {
        return [
            'contract.required'=>"Debe indicar su número de contrato",
            'contract.regex'=>"El número de contrato no es válido",
            'barcode.required'=>"El código de barras es obligatorio",
            'barcode.regex'=>"El código de barras no es válido",
        ];
    }
}
