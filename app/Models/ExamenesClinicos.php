<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenesClinicos extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'examen_extraoral',
        'examen_intraoral',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
