<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemModuloUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|unique:system_modulos,nombre,'.$this->request->get('id').',id',
            'key' => 'required|unique:system_modulos,key,'.$this->request->get('id').',id',
            'route' => 'required|unique:system_modulos,route,'.$this->request->get('id').',id',
            'mdi_icon' => 'nullable',
        ];
    }
}
