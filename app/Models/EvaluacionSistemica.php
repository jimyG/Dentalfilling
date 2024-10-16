<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionSistemica extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'historia_enfermedad',
        'historia_medica_personal',
        'antecedentes_medicos_familiares',
        
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
