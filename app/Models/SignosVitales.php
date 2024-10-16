<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignosVitales extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'pa',
        'pulso',
        'temperatura',
    ];

    // Relación inversa con Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
