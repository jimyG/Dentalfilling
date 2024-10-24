<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsentimientoInformado extends Model
{
    use HasFactory;

    protected $table = 'consentimientos_informados'; // Agregar esta línea

    protected $fillable = ['medico_id', 'patient_id', 'contenido'];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
