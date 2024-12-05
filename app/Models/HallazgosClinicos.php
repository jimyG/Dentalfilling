<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HallazgosClinicos extends Model
{
    use HasFactory;

    // Especifica la tabla si el nombre no sigue la convención plural
    protected $table = 'hallazgos_clinicos';

    // Campos que son asignables en masa
    protected $fillable = [
        'nombre',
        'color',
    ];
}
