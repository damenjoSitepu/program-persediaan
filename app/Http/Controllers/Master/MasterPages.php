<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterPages extends Controller
{
    public $Userlogin, $Jabatan, $Supplier, $Barang, $Persediaan;

    public function __construct()
    {
        $this->Userlogin    = new \App\Models\UserloginModel();
        $this->Jabatan      = new \App\Models\JabatanModel();
        $this->Supplier     = new \App\Models\SupplierModel();
        $this->Barang       = new \App\Models\BarangModel();
        $this->Persediaan   = new \App\Models\PersediaanModel();
    }

    // Halaman Master Data
    public function index($sub = '', $id = '')
    {
        // Validasi Session
        if (!session()->get('login'))
            return redirect()->route('authentification')->with('message', 'Anda Belum Login!');

        $data = [
            'title'                     => 'Master Data',
            'sub'                       => $sub,
            'getPegawai'                => $this->Userlogin->getAllUserLogin(),
            'getPegawaiById'            => $this->Userlogin->getUserLoginById($id),
            'getSupplier'               => $this->Supplier->getAllSupplier(),
            'getSupplierById'           => $this->Supplier->getSupplierById($id),
            'getBarang'                 => $this->Barang->getAllBarang(),
            'getBarangById'             => $this->Barang->getBarangById($id),
            'getJabatan'                => $this->Jabatan->getJabatan(),
            'pegawaiId'                 => $id,
            'checkBarangInPersediaan'   => $this->Persediaan->getBarangInPersediaan($id)
        ];

        return view('master/index', $data);
    }
}
