<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    use HasFactory;

    protected $table = 'sexos'; // Asegúrate de que el nombre de la tabla sea correcto
    protected $fillable = ['nombre'];

    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }

}
