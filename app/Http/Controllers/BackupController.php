<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.backup'); // Cambia la vista si es necesario
    }

    public function generarRespaldo()
    {
        try {
            $nombreBackup = 'clinica2.sql';
            $backupSql = "";

            // Conexión a la base de datos usando PDO
            $pdo = DB::connection()->getPdo();

            // Obtener todas las tablas
            $tablas = $pdo->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);

            foreach ($tablas as $tabla) {
                // Generar la estructura de la tabla
                $createTableStmt = $pdo->query("SHOW CREATE TABLE `$tabla`")->fetch(\PDO::FETCH_ASSOC)['Create Table'];
                $backupSql .= "DROP TABLE IF EXISTS `$tabla`;\n";
                $backupSql .= $createTableStmt . ";\n\n";

                // Obtener los datos de la tabla
                $filas = $pdo->query("SELECT * FROM `$tabla`")->fetchAll(\PDO::FETCH_ASSOC);

                foreach ($filas as $fila) {
                    $columnas = array_keys($fila);
                    $valores = array_map([$pdo, 'quote'], array_values($fila));
                    $backupSql .= "INSERT INTO `$tabla` (`" . implode('`, `', $columnas) . "`) VALUES (" . implode(', ', $valores) . ");\n";
                }

                $backupSql .= "\n";
            }

            // Forzar la descarga inmediata del respaldo
            return Response::make($backupSql, 200, [
                'Content-Type' => 'application/sql',
                'Content-Disposition' => 'attachment; filename="' . $nombreBackup . '"',
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el respaldo: ' . $e->getMessage());
        }
    }
}
