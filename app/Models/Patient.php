<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'expediente',
        'fecha_ingreso',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'genero',
        'edad',
        'estado_civil',
        'telefono',
        'celular',
        'correo',
        'whatsapp',
        'emergencia_contacto',
        'emergencia_telefono',
        'ha_visitado_odontologo',
    ];

    public function evaluacionSistemica()
    {
        return $this->hasMany(EvaluacionSistemica::class);
    }

    public function signosVitales()
    {
        return $this->hasMany(SignosVitales::class);
    }

    public function examenesClinicos()
    {
        return $this->hasMany(ExamenesClinicos::class);
    }

    public function evaluacionRegional()
    {
        return $this->hasMany(EvaluacionRegional::class, 'patient_id');
    }

    public function odontograma()
{
    return $this->hasOne(Odontograma::class, 'paciente_id');
}

public function enfermedadesComunes()
{
    return $this->hasOne(EnfermedadesComunes::class);
}


    public function consultas()
{
    return $this->hasMany(Consulta::class);
}

public function tratamientosDentales()
{
    return $this->hasMany(TratamientoDental::class);
}


}
