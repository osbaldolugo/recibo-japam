<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\AppUser;

class CreateAppUserRequest extends FormRequest
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
            'email' => 'required|email|same:old_email',
            'password' => 'required|min:8',
            'phone_number' => ['nullable', 'regex:/^([(]([0-9]{3})[)][ ]([0-9]{3})[-]([0-9]{4}))$/'],
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
            'email.required' => 'Es necesario establecer el correo al que le llegara su recibo digital',
            'email.email' => 'El correo no corresponde con una dirección de correo electrónico',
            'email.same' => 'Los correos no coinciden',
            'password.required' => 'Es necesario establecer una contraseña',
            'password.min' => 'La contraseña no debe contener menos de 8 caracteres',
            'phone_number.regex' => 'El teléfono celular debe contener al menos 10 dígitos'
        ];
    }
}
