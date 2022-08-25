<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomePages extends Controller
{
    // Halaman Beranda Untuk admin dan picker gudang
    public function index()
    {
        // Validasi Session
        if (!session()->get('login'))
            return redirect()->route('authentification')->with('message', 'Anda Belum Login!');

        $data = [
            'title'     => 'Beranda'
        ];

        return view('home/index', $data);
    }
}
