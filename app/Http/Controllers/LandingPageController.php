<?php

namespace App\Http\Controllers;

class LandingPageController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function index()
    {
        return view('landingPage'); // Retorna la vista que creaste
    }

}