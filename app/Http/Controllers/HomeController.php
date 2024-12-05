<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Administrador')) {
            return view('admin.dashboard'); // Vista para Administradores
        } elseif ($user->hasRole('Médico')) {
            return view('doctor.dashboard'); // Vista para Médicos
        } elseif ($user->hasRole('Paciente')) {
            return view('patient.dashboard'); // Vista para Pacientes
        } else {
            return redirect('/'); // Redirige a la página de inicio si el rol no coincide
        }
    }
}