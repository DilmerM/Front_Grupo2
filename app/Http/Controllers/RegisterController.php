<?php

namespace App\Http\Controllers;

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function index()
    {
        return view('register'); // Retorna la vista que creaste
    }

}