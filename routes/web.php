<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\OdontogramaController;
use App\Http\Controllers\ToothSurfaceController;
use App\Http\Controllers\UserController; // Importamos el controlador UserController
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
// Web Routes
|--------------------------------------------------------------------------
// Aquí es donde puedes registrar las rutas web para tu aplicación.
// Estas rutas están cargadas por el RouteServiceProvider y se agrupan
// en el grupo "web" middleware. ¡Haz algo grandioso!
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas protegidas por roles

// Rutas para Administrador
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    

    // Gestión de Usuarios con UserController
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/admin/create-user', [AdminController::class, 'createUserForm'])->name('admin.createUserForm');
    Route::post('/admin/create-user', [AdminController::class, 'createUser'])->name('admin.createUser');
    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manageUsers');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.editUser');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.updateUser');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Consentimientos y Backups
    Route::get('/admin/consent', [AdminController::class, 'consentForm'])->name('admin.consentForm');
    Route::get('/admin/backup', [AdminController::class, 'backup'])->name('admin.backup');

    // Módulo de Especialidades
    Route::prefix('admin/especialidades')->name('admin.especialidades.')->group(function () {
        Route::get('/', [EspecialidadesController::class, 'index'])->name('index');
        Route::get('/create', [EspecialidadesController::class, 'create'])->name('create');
        Route::post('/', [EspecialidadesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [EspecialidadesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [EspecialidadesController::class, 'update'])->name('update');
        Route::delete('/{id}', [EspecialidadesController::class, 'destroy'])->name('destroy');
    });


    // Rutas para Paciente
    Route::prefix('admin/patient')->name('admin.patient.')->group(function () {
        Route::get('/', [AdminController::class, 'indexPaciente'])->name('index'); // Cambio aquí
        Route::get('/create', [AdminController::class, 'createPaciente'])->name('create');
        Route::post('/store', [AdminController::class, 'storePaciente'])->name('store');
        Route::delete('/{id}', [AdminController::class, 'destroyPaciente'])->name('destroy');
        Route::get('/{id}', [PatientController::class, 'show'])->name('show');
         // Ruta para la búsqueda en tiempo real por AJAX
        Route::get('/search', [AdminController::class, 'searchPaciente'])->name('patient.search');

    });

    Route::get('/admin/patients/search', [PatientController::class, 'search'])->name('admin.patient.search');
    Route::get('/dashboard/counts', [DashboardController::class, 'getCounts']);
    Route::post('/guardar-odontograma', [OdontogramaController::class, 'guardar']); 
    

    // Ruta para mostrar el formulario de edición
    Route::get('admin/patient/{id}/edit', [PatientController::class, 'edit'])->name('admin.patient.edit');

    Route::delete('/admin/patients/{paciente}/regions/{region}', [PatientController::class, 'destroyRegion'])->name('admin.patient.regions.destroy');
   // Route::delete('admin/patients/{patientId}/regions/{regionId}', [AdminController::class, 'destroyRegion'])->name('admin.patient.destroyRegion');

   // Route::delete('admin/paciente/{paciente}/region/{region_id}', [PatientController::class, 'removeRegion'])->name('admin.patient.remove_region');

    // Ruta para actualizar los datos
    Route::put('admin/patient/{id}', [PatientController::class, 'update'])->name('admin.patient.update');

    // Rutas para Médico
    Route::prefix('admin/doctor')->name('admin.doctor.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');          // Listar médicos
        Route::get('/create', [AdminController::class, 'create'])->name('create');   // Formulario para crear un médico
        Route::post('/', [AdminController::class, 'store'])->name('store');          // Guardar un nuevo médico
        Route::get('/{id}/edit', [AdminController::class, 'editDoctor'])->name('edit');    // Formulario para editar un médico
        Route::put('/{id}', [AdminController::class, 'updateDoctor'])->name('update');     // Actualizar un médico
        Route::delete('/{id}', [AdminController::class, 'destroyDoctor'])->name('destroy'); // Eliminar un médico
    });

    // Rutas para Odontograma
    Route::prefix('admin/odontograma')->name('admin.odontograma.')->group(function () {
        Route::get('/', [AdminController::class, 'indexOdontograma'])->name('index'); // Llama al método desde AdminController
        Route::post('/tooth-surfaces', [ToothSurfaceController::class, 'store'])->name('tooth-surfaces.store');
        Route::get('/create', [AdminController::class, 'createOdontograma'])->name('create'); // Llama al método create de AdminController
        Route::post('/', [AdminController::class, 'storeOdontograma'])->name('store'); // Llama al método store de AdminController
        Route::get('/{id}/edit', [AdminController::class, 'editOdontograma'])->name('edit'); // Llama al método edit de AdminController
        Route::put('/{id}', [AdminController::class, 'updateOdontograma'])->name('update'); // Llama al método update de AdminController
        Route::delete('/{id}', [AdminController::class, 'destroyOdontograma'])->name('destroy'); // Llama al método destroy de AdminController
    });

    // Ruta para obtener datos del diente
    Route::get('/tooth-surfaces/{id}', [ToothSurfaceController::class, 'getToothSurfaces']);
    Route::post('/tooth-surfaces/store', [ToothSurfaceController::class, 'store'])->name('tooth-surfaces.store');

    Route::get('/doctors', [AdminController::class, 'getDoctors'])->name('doctors.list');
    Route::get('/patients', [AdminController::class, 'getPatients'])->name('patients.list');
});