<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthPages extends Controller
{
    // Halaman Autentifikasi Login
    public function index()
    {
        $data = [
            'title'     => 'Login Page'
        ];

        return view('auth/index', $data);
    }
}
