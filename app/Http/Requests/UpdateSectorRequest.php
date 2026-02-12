<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 01:07 PM
 */

namespace App\Http\Requests;

use App\Models\Sector;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSectorRequest extends FormRequest
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
        return Sector::$rules;
    }

}