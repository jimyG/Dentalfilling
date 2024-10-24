<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Backup\Facades\Backup;

class BackupController extends Controller
{
    public function createBackup()
    {
        try {
            // Ejecutar el proceso de respaldo
            Backup::run();

            return back()->with('success', 'Respaldo generado con éxito.');
        } catch (\Exception $e) {
            dd($e->getMessage()); // Muestra el mensaje de error si falla
        }
    }
}
