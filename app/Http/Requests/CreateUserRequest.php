<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 28/03/2018
 * Time: 09:24 AM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'user.email' => 'required|email',
            'user.password' => 'required|min:8',
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
            'user.email.required' => 'Es necesario establecer el usuario de Inicio de Sesión',
            'user.email.email' => 'El correo no corresponde con una dirección de correo electrónico',
            'user.password.required' => 'Es necesario establecer una contraseña',
            'user.password.min' => 'La contraseña no debe contener menos de 8 caracteres',
            'category.required' => 'Es necesario asignar el usuario a al menos una categoría',
        ];
    }
}