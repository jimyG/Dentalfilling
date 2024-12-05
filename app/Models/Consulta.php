<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'plan_atencion', 'motivo_consulta', 'diagnostico', 'tratamiento_propuesto', 'observaciones'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function tratamientosDentales()
{
    return $this->belongsTo(TratamientoDental::class, 'tratamiento_dental_id');
    
}
}
