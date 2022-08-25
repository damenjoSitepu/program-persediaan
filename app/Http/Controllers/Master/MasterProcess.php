<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\SelectKeeper;

class MasterProcess extends Controller
{
    public $Userlogin, $Supplier, $Barang;

    public function __construct()
    {
        $this->Userlogin    = new \App\Models\UserloginModel();
        $this->Supplier     = new \App\Models\SupplierModel();
        $this->Barang       = new \App\Models\BarangModel();
    }

    // Proses untuk menghapus data pegawai ( admin / picker gudang / user )
    public function hapus($id = '')
    {
        // Mendpatakan User Login Id
        $user_login_id = $id;

        // dapatkan data user
        $getUserLogin = $this->Userlogin->getRecentlyUserLogin();

        // Menghapus ( Soft Delete )
        $this->Userlogin->deleteUserLogin($user_login_id);

        // Message Card Information
        $dateMessage = date('l, d-M-Y');

        $messageCard = "
         <div class='card'>
             <div class='card-body shadow rounded'>
                 <i class='fas fa-circle text-danger'></i> Data Pegawai: <span class='text-danger fw-bold'>{$getUserLogin->name}</span> Berhasil Dihapus Pada <span class='text-danger fw-bold'>{$dateMessage}</span>.
             </div>
         </div>
         ";

        // Akhir Error Card Information

        // Kembalikan 
        return redirect()->route('master-data-sub', ['sub' => 'pegawai'])->with('message', $messageCard);
    }

    // Proses untuk mengubah data pegawai ( admin / picker gudang / user )
    public function ubah(Request $request, $id = '')
    {
        // Validasi
        $request->validate([
            'name'              => 'required',
            'jabatan_id'        => [new SelectKeeper]
        ]);

        // Dapatkan Data
        $name = $request->name;
        $jabatan_id = $request->jabatan_id;
        $password = $request->password ? $request->password : $this->Userlogin->getUserLoginById($id)->password;

        // Tampung ke array
        $dataPegawai = [
            'name'          => $name,
            'jabatan_id'    => $jabatan_id,
            'password'      => $password
        ];

        // Masukkan ke dalam database user_login
        $this->Userlogin->updateUserLogin($id, $dataPegawai);

        // Message Card Information
        $getUserLogin = $this->Userlogin->getUserLoginById($id);

        $dateMessage = date('l, d-M-Y');

        $messageCard = "
         <div class='card'>
             <div class='card-body shadow rounded'>
                 <i class='fas fa-circle text-success'></i> Data Pegawai ID: <span class='text-success fw-bold'>{$getUserLogin->user_login_id}</span> Berhasil Diubah Pada <span class='text-success fw-bold'>{$dateMessage}</span>.
             </div>
         </div>
         ";

        // Kembalikan 
        return redirect()->route('master-data-sub', ['sub' => 'pegawai'])->with('message', $messageCard);
    }

    // Proses untuk membuat data pegawai ( admin / picker gudang / user )
    public function index(Request $request)
    {
        // Validasi
        $request->validate([
            'name'          => 'required',
            'jabatan_id'    => [new SelectKeeper]
        ]);

        // Dapatkan Data
        $name = $request->name;
        $jabatan_id = $request->jabatan_id;

        // Mengolah Nama Pegawai untuk dijadikan default username
        $setUsername = explode(" ", $name);

        // Ambil Data nama berdasarkan nama pertama dari input di database
        $getUsername = $this->Userlogin->getUserLoginByFirstWord('name', $setUsername[0]);

        // Ambil semua nama depannya ( ini adalah username ) dan jadikan array.
        $rawUsername = [];
        foreach ($getUsername as $username) {
            $explodeUsername = explode(" ", $username->name);
            array_push($rawUsername, strtolower($explodeUsername[0]));
        }

        // Periksa ada berapa banyak username yang namanya sama dengan calon username pegawai baru
        $count = 0;
        for ($check = 0; $check < count($rawUsername); $check++) {
            if (strtolower($setUsername[0]) == $rawUsername[$check])
                $count += 1;
        }

        // Gabung dan tetapkan string username pegawai baru
        $getDefaultUsername = $count != 0 ? strtolower($setUsername[0]) . ++$count : strtolower($setUsername[0]) . '1';

        // Simpan ke dalam array
        $dataPegawai = [
            'name'          => $name,
            'jabatan_id'    => $jabatan_id,
            'username'      => $getDefaultUsername
        ];

        // Masukkan ke dalam database user_login
        $this->Userlogin->insertUserLogin($dataPegawai);

        $getUserLogin = $this->Userlogin->getRecentlyUserLogin();

        // Message Card Information
        $dateMessage = date('l, d-M-Y');

        $messageCard = "
        <div class='card'>
            <div class='card-body shadow rounded'>
                <i class='fas fa-circle text-primary'></i> Data Supplier: <span class='text-primary fw-bold'>{$getUserLogin->name}</span> Berhasil Dibuat Pada <span class='text-primary fw-bold'>{$dateMessage}</span>.
            </div>
        </div>
        ";

        // Kembalikan 
        return redirect()->route('master-data-sub', ['sub' => 'pegawai'])->with('message', $messageCard);
    }

    // Proses untuk menghapus data supplier 
    public function hapussupplier($id = '')
    {
        // Mendpatakan Supplier id
        $supplier_id = $id;

        // Dapatkan data supplier
        $getSupplier = $this->Supplier->getSupplierById($id);

        // Menghapus ( Soft Delete )
        $this->Supplier->deleteSupplier($supplier_id);

        // Message Card Information
        $dateMessage = date('l, d-M-Y');

        $messageCard = "
        <div class='card'>
            <div class='card-body shadow rounded'>
                <i class='fas fa-circle text-danger'></i> Data Supplier: <span class='text-danger fw-bold'>{$getSupplier->nm_supplier}</span> Berhasil Dihapus Pada <span class='text-danger fw-bold'>{$dateMessage}</span>.
            </div>
        </div>
        ";

        // Akhir Error Card Information

        // Kembalikan 
        return redirect()->route('master-data-sub', ['sub' => 'supplier'])->with('message', $messageCard);
    }

    // Proses untuk mengubah data supplier 
    public function ubahsupplier(Request $request, $id = '')
    {
        // Validasi
        $request->validate([
            'nm_supplier'               => 'required',
            'alamat'                    => 'required',
            'no_telepon'                => 'required',
        ]);

        // Dapatkan Data
        $nm_supplier = $request->nm_supplier;
        $alamat = $request->alamat;
        $no_telepon = $request->no_telepon;


        // Tampung ke array
        $dataSupplier = [
            'nm_supplier'           => $nm_supplier,
            'alamat'                => $alamat,
            'no_telepon'            => $no_telepon
        ];

        // Masukkan ke dalam database user_login
        $this->Supplier->updateSupplier($id, $dataSupplier);

        // Message Card Information
        $getSupplier = $this->Supplier->getSupplierById($id);

        $dateMessage = date('l, d-M-Y');

        $messageCard = "
        <div class='card'>
            <div class='card-body shadow rounded'>
                <i class='fas fa-circle text-success'></i> Data Supplier ID: <span class='text-success fw-bold'>{$getSupplier->supplier_id}</span> Berhasil Diubah Pada <span class='text-success fw-bold'>{$dateMessage}</span>.
            </div>
        </div>
        ";

        // Kembalikan 
        return redirect()->route('master-data-sub', ['sub' => 'supplier'])->with('message', $messageCard);
    }

    // Proses untuk membuat data supplier 
    public function buatsupplier(Request $request)
    {
        // Validasi
        $request->validate([
            'nm_supplier'           => 'required',
            'alamat'                => 'required',
            'no_telepon'            => 'required'
        ]);

        // Dapatkan Data
        $nm_supplier        = $request->nm_supplier;
        $alamat             = $request->alamat;
        $no_telepon         = $request->no_telepon;

        // Simpan ke dalam array
        $dataSupplier = [
            'nm_supplier'   => $nm_supplier,
            'alamat'        => $alamat,
            'no_telepon'    => $no_telepon
        ];

        // Masukkan ke dalam database user_login
        $this->Supplier->insertSupplier($dataSupplier);

        $getSupplier = $this->Supplier->getRecentlySupplier();

        // Message Card Information
        $dateMessage = date('l, d-M-Y');

        $messageCard = "
        <div class='card'>
            <div class='card-body shadow rounded'>
                <i class='fas fa-circle text-primary'></i> Data Supplier: <span class='text-primary fw-bold'>{$getSupplier->nm_supplier}</span> Berhasil Dibuat Pada <span class='text-primary fw-bold'>{$dateMessage}</span>.
            </div>
        </div>
        ";

        // Kembalikan 
        return redirect()->route('master-data-sub', ['sub' => 'supplier'])->with('message', $messageCard);
    }

    // Proses untuk menghapus data barang 
    public function hapusbarang($id = '')
    {
        // Mendpatakan Barang id
        $barang_id = $id;

        // Data Barang
        $getBarang = $this->Barang->getBarangById($id);

        // Menghapus ( Soft Delete )
        $this->Barang->deleteBarang($barang_id);

        // Message Card Information
        $dateMessage = date('l, d-M-Y');

        $messageCard = "
        <div class='card'>
            <div class='card-body shadow rounded'>
                <i class='fas fa-circle text-danger'></i> Data Barang: <span class='text-danger fw-bold'>{$getBarang->nm_barang}</span> Berhasil Dihapus Pada <span class='text-danger fw-bold'>{$dateMessage}</span>.
            </div>
        </div>
        ";

        // Akhir Error Card Information

        // Kembalikan 
        return redirect()->route('master-data-sub', ['sub' => 'barang'])->with('message', $messageCard);
    }

    // Proses untuk mengubah data barang 
    public function ubahbarang(Request $request, $id = '')
    {
        // Validasi
        $request->validate([
            'nm_barang'                 => 'required',
            'satuan'                    => 'required'
        ]);

        // Dapatkan Data
        $nm_barang  = $request->nm_barang;
        $satuan     = $request->satuan;


        // Tampung ke array
        $dataBarang = [
            'nm_barang'             => $nm_barang,
            'satuan'                => $satuan
        ];

        // Masukkan ke dalam database user_login
        $this->Barang->updateBarang($id, $dataBarang);

        // Message Card Information
        $getBarang = $this->Barang->getBarangById($id);

        $dateMessage = date('l, d-M-Y');

        $messageCard = "
        <div class='card'>
            <div class='card-body shadow rounded'>
                <i class='fas fa-circle text-success'></i> Data Barang ID: <span class='text-success fw-bold'>{$getBarang->barang_id}</span> Berhasil Diubah Pada <span class='text-success fw-bold'>{$dateMessage}</span>.
            </div>
        </div>
        ";

        // Kembalikan 
        return redirect()->route('master-data-sub', ['sub' => 'barang'])->with('message', $messageCard);
    }

    // Proses untuk mengubah data barang ( stok ) 
    public function ubahbarangstok(Request $request, $id = '')
    {
        // Validasi
        $request->validate([
            'jumlah'                 => 'required'
        ]);

        // Dapatkan Data
        $jumlah  = $request->jumlah;


        // Tampung ke array
        $dataStok = [
            'jumlah'             => $jumlah,
        ];

        // Masukkan ke dalam database user_login
        $this->Barang->updateBarangStok($id, $dataStok);

        // Kembalikan 
        return redirect()->route('master-data-sub', ['sub' => 'barang'])->with('message', "Data Stok Barang Dengan Barang ID: {$this->Barang->getBarangById($id)->barang_id} Berhasil Diubah!");
    }

    // Proses untuk membuat data barang 
    public function buatbarang(Request $request)
    {
        // Validasi
        $request->validate([
            'nm_barang'             => 'required',
            'satuan'                => 'required',
            'jumlah'                => 'required',
        ]);

        // Dapatkan Data
        $nm_barang          = $request->nm_barang;
        $satuan             = $request->satuan;
        $jumlah             = $request->jumlah;

        // Simpan ke dalam array
        $dataBarang = [
            'nm_barang'     => $nm_barang,
            'satuan'        => $satuan,
            'jumlah'        => $jumlah
        ];

        // Masukkan ke dalam database barang
        $this->Barang->insertBarang($dataBarang);

        $getBarang = $this->Barang->getRecentlyBarang();

        // Message Card Information
        $dateMessage = date('l, d-M-Y');

        $messageCard = "
        <div class='card'>
            <div class='card-body shadow rounded'>
                <i class='fas fa-circle text-primary'></i> Data Barang: <span class='text-primary fw-bold'>{$getBarang->nm_barang}</span> Berhasil Dibuat Pada <span class='text-primary fw-bold'>{$dateMessage}</span>.
            </div>
        </div>
        ";

        // Kembalikan 
        return redirect()->route('master-data-sub', ['sub' => 'barang'])->with('message', $messageCard);
    }
}
