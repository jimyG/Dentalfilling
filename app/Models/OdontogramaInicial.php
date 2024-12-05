<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdontogramaInicial extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención de nombres de Laravel
    protected $table = 'odontograma_inicial';

    // Define los campos que son asignables en masa
    protected $fillable = [
        'paciente_id', // ID del paciente
        'diente', // Nombre del diente
        'area', // Área del diente
        'tratamiento_id', // ID del tratamiento
    ];

    // Define la relación con el modelo Paciente
    public function paciente()
    {
        return $this->belongsTo(Patient::class, 'paciente_id'); // Ajusta si el nombre de la clase es diferente
    }

    // Define la relación con el modelo Tratamiento
    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class, 'tratamiento_id'); // Ajusta si el nombre de la clase es diferente
    }
}
