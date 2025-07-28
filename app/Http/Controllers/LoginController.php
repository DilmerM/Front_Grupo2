<?php

namespace App\Http\Controllers;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function index()
    {
        return view('login'); // Retorna la vista que creaste
    }

}