<?php

// app/Models/Odontograma.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontograma extends Model
{
    use HasFactory;

    protected $table = 'odontograma'; // Agrega esta línea para especificar el nombre de la tabla

    protected $fillable = ['paciente_id', 'diente', 'area', 'tratamiento_id'];

    public function patient()
{
    return $this->belongsTo(Patient::class, 'paciente_id'); // Asegúrate de que el nombre sea correcto
}

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }
}
