<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 28/03/2018
 * Time: 12:08 PM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'user.name' => 'required',
            'category' => 'required',
        ];
    }

    /**
     * Get the message validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user.name.required' => 'El nombre no puede quedar vacio',
            'category.required' => 'Es necesario asignar el usuario a al menos una categoría',
        ];
    }
}