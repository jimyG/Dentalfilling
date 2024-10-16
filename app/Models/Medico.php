<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'dui', 'edad', 'LicenseNumber', 'address', 'phone', 'especialidad_id', 'sexo_id'
    ];

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function sexo()
    {
        return $this->belongsTo(Sexo::class);
    }
}
