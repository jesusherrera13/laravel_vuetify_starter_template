<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemModuloMenuUpdateRequest extends FormRequest
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
            'cuenta_id' => 'required',
            'nombre' => 'required|unique:system_modulos_menus,nombre,'.$this->request->get('id').',id,modulo_id,'.$this->request->get('modulo_id'),
            'key' => 'nullable|unique:system_modulos_menus,key,'.$this->request->get('id').',id',
            'route' => 'nullable|unique:system_modulos_menus,route,'.$this->request->get('id').',id',
            'mdi_icon' => 'nullable',
            'status' => 'required',
            'modulo_id' => 'required',
        ];
    }
}
