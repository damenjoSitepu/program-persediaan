<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthProcess extends Controller
{
    public $Userlogin;

    public function __construct()
    {
        $this->Userlogin = new \App\Models\UserloginModel();
    }

    // Proses login
    public function index(Request $request)
    {
        // Get data
        $username = $request->username;
        $password = $request->password;

        // Get Username data
        $getUserdata = $this->Userlogin->getUserLoginByUsername($username);

        // Validasi
        $request->validate([
            'username'  => 'required',
            'password'  => 'required'
        ]);

        // Check username availability
        if (empty($getUserdata)) {
            session()->flash('message', 'Akun Anda Tidak Ada Di Data Kami!');
            return redirect()->route('authentification');
        } else {
            // Check password
            if ($getUserdata->password != $password) {
                session()->flash('message', 'Password Akun Salah!');
                return redirect()->route('authentification');
            } else {
                // Pindahkan user sesuai kelas / tingkatannya
                // Simpan Session 
                $sessionData = [
                    'user_id'               => $getUserdata->user_login_id,
                    'name'                  => $getUserdata->name,
                    'jabatan_id'            => $getUserdata->jabatan_id,
                    'username'              => $getUserdata->username
                ];
                session()->put('login', $sessionData);

                session()->flash('message', 'Selamat Datang Admin!');
                return redirect()->route('homes');
            }
        }
    }

    // Proses Log-out
    public function logout()
    {
        session()->forget('login');
        session()->flush();

        // Set Flashdata
        return redirect()->route('authentification')->with('message', 'Anda Telah Keluar!');
    }
}
