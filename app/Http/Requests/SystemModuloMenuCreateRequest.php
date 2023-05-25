<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemModuloMenuCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|unique:system_modulos_menus,nombre,null,id,modulo_id,'.$this->request->get('modulo_id'),
            'key' => 'required|unique:system_modulos_menus,key,null,id',
            'route' => 'required|unique:system_modulos_menus,route,null,id',
            'mdi_icon' => 'nullable',
            'status' => 'required',
            'modulo_id' => 'required',
        ];
    }
}
