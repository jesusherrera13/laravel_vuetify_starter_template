<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemModuloCreateRequest extends FormRequest
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
            'nombre' => 'required|unique:system_modulos,nombre,null,id',
            'key' => 'required|unique:system_modulos,key,null,id',
            'route' => 'required|unique:system_modulos,route,null,id',
            'mdi_icon' => 'nullable',
            'status' => 'required',
        ];
    }
}
