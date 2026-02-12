<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 04:25 PM
 */

namespace App\Http\Requests;

use App\Models\Suburb;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSuburbRequest extends FormRequest
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
        return Suburb::$rules;
    }

}