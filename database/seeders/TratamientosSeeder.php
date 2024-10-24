<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TratamientosSeeder extends Seeder
{
    public function run()
    {
        DB::table('tratamientos')->insert([
            ['id' => 1, 'nombre' => 'Obturación', 'color' => '#FF0000'],
            ['id' => 2, 'nombre' => 'Extracción', 'color' => '#0000FF'],
            ['id' => 3, 'nombre' => 'Limpieza', 'color' => '#00FF00'],
            ['id' => 4, 'nombre' => 'Blanqueamiento', 'color' => '#FFFF00'],
            ['id' => 5, 'nombre' => 'Tratamiento de conducto', 'color' => '#FFA500'],
        ]);
    }
}
