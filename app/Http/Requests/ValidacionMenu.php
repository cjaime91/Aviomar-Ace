<?php

namespace App\Http\Requests;

use App\Rules\ValidarCampoURL;
use Illuminate\Foundation\Http\FormRequest;

class ValidacionMenu extends FormRequest
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
            'nombre' => 'required | max:50 | unique:av_menu,nombre,' . $this->route('id'),
            'url' => ['required', 'max:100', new ValidarCampoURL],
            'icono' => 'nullable | max:50',
        ];
    }

    /**public function messages()
    {
        return[
            'nombre.required' => 'El nombre es requerido',
            'url.required' => 'La URL es requerida',
            'url.max:100' => 'La URL tiene mas de 100 Caracteres'
        ];
    }*/
}
