<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePacienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer',
            'sexo' => 'required|exists:sexos,id',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'pa' => 'nullable|string|max:20',
            'pulso' => 'nullable|integer',
            'temperatura' => 'nullable|numeric',
            'frecuencia_respiratoria' => 'nullable|integer',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ];
    }
}
