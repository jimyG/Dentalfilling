<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnfermedadesComunes extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'patient_id', 'hipertension', 'diabetes', 'hemofilia', 'tumor_labio', 'medicamento',
        'tumor_cervico', 'sindrome_down', 'tumor_mama', 'tumor_pulmon', 'autismo', 
        'tumor_colon', 'tumor_estomago', 'paralisis', 'erc', 'cardiopatia', 'endocarditis', 'otros'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
