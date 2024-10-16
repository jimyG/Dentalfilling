<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'region',
        'condicion',
        'observacion',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

