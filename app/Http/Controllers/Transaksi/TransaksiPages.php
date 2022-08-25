<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransaksiPages extends Controller
{
    public $Userlogin, $Jabatan, $Supplier, $Barang, $Persediaan, $Pesan;

    public function __construct()
    {
        $this->Userlogin    = new \App\Models\UserloginModel();
        $this->Jabatan      = new \App\Models\JabatanModel();
        $this->Supplier     = new \App\Models\SupplierModel();
        $this->Barang       = new \App\Models\BarangModel();
        $this->Persediaan   = new \App\Models\PersediaanModel();
        $this->Pesan        = new \App\Models\PesanModel();
    }

    // Halaman Transaksi Khusus Picker
    public function indexs($sub = '', $id = '')
    {
        // Validasi Session
        if (!session()->get('login'))
            return redirect()->route('authentification')->with('message', 'Anda Belum Login!');

        $data = [
            'title'             => 'Transaksi',
            'sub'               => $sub,
            'getPegawai'        => $this->Userlogin->getAllUserLogin(),
            'getPegawaiById'    => $this->Userlogin->getUserLoginById($id),
            'getSupplier'       => $this->Supplier->getAllSupplier(),
            'getSupplierById'   => $this->Supplier->getSupplierById($id),
            'getBarang'         => $this->Barang->getAllBarang(),
            'getBarangById'     => $this->Barang->getBarangById($id),
            'getJabatan'        => $this->Jabatan->getJabatan(),
            'id'                => $id,
            'getFormBarangByPicker'     => $this->Persediaan->getFormBarangByPicker()
        ];

        return view('transaksi-extra/index', $data);
    }

    // Halaman Transaksi
    public function index($sub = '', $id = '')
    {
        // Validasi Session
        if (!session()->get('login'))
            return redirect()->route('authentification')->with('message', 'Anda Belum Login!');

        // Jika sub menuju ke form-barang, dan belum ada pegawai, maka tolak masuk ke dalam
        if ($sub == 'form-barang-tambah') {
            if (count($this->Userlogin->getAllUserLoginPicker()) == 0) {
                $messageCard = "
                <div class='card'>
                    <div class='card-body shadow rounded'>
                        <i class='fas fa-circle text-success'></i> Anda Harus Membuat Setidaknya Satu Data Pegawai Picker Gudang Untuk Masuk Ke Dalam Laman Form Barang Ini!
                    </div>
                </div>
                ";

                // Kembalikan 
                return redirect()->route('master-data-sub', ['sub' => 'pegawai'])->with('message', $messageCard);
            }

            if (count($this->Barang->getAllBarang()) == 0) {
                $messageCard = "
                <div class='card'>
                    <div class='card-body shadow rounded'>
                        <i class='fas fa-circle text-success'></i> Anda Harus Membuat Setidaknya Satu Data Unit Barang Untuk Masuk Ke Dalam Laman Form Barang Ini!
                    </div>
                </div>
                ";

                // Kembalikan 
                return redirect()->route('master-data-sub', ['sub' => 'barang'])->with('message', $messageCard);
            }
        }

        if ($sub == 'daftar-pesan') {
            if (count($this->Pesan->getAllPesan()) == 0) {
                $messageCard = "
                <div class='card'>
                    <div class='card-body shadow rounded'>
                        <i class='fas fa-circle text-danger'></i> Anda Harus Menyelesaikan Setidaknya Satu <span class='fw-bold text-danger'>List Order</span> Untuk Masuk Ke Dalam Laman <span class='fw-bold text-danger'>List Order</span> Ini!
                    </div>
                </div>
                ";

                // Kembalikan 
                return redirect()->route('transaksi-data-sub', ['sub' => 'form-barang'])->with('message', $messageCard);
            }
        }

        if ($sub == 'detail-form-barang') {
            if (count($this->Supplier->getAllSupplier()) == 0) {
                $messageCard = "
                <div class='card'>
                    <div class='card-body shadow rounded'>
                        <i class='fas fa-circle text-danger'></i> Anda Harus Membuat Setidaknya <span class='text-danger fw-bold'>Satu Supplier</span> Untuk Mengubah <span class='fw-bold text-danger'>Form Data Barang</span> Ini Menjadi <span class='fw-bold text-danger'>List Order</span>!
                    </div>
                </div>
                ";

                // Kembalikan 
                return redirect()->route('master-data-sub', ['sub' => 'supplier'])->with('message', $messageCard);
            }
        }

        $data = [
            'title'             => 'Transaksi',
            'sub'               => $sub,
            'getPesan'          => $this->Pesan->getAllPesan(),
            'getPesanById'      => $this->Pesan->getPesanById($id),
            'getPegawai'        => $this->Userlogin->getAllUserLogin(),
            'getPegawaiById'    => $this->Userlogin->getUserLoginById($id),
            'getSupplier'       => $this->Supplier->getAllSupplier(),
            'getSupplierById'   => $this->Supplier->getSupplierById($id),
            'getBarang'         => $this->Barang->getAllBarang(),
            'getBarangById'     => $this->Barang->getBarangById($id),
            'getJabatan'        => $this->Jabatan->getJabatan(),
            'id'                => $id,
            'getFormBarang'     => $this->Persediaan->getFormBarang()
        ];

        return view('transaksi/index', $data);
    }
}
