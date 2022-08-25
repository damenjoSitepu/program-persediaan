<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PersediaanModel extends Model
{
    use HasFactory;

    // Insert Persediaan
    public function insertPersediaan($dataFormBarang = [])
    {
        $tanggal_transaksi = $dataFormBarang['tanggal_transaksi'];
        $admin_id           = $dataFormBarang['admin_id'];
        $picker_gudang_id = $dataFormBarang['picker_gudang_id'];

        DB::statement("INSERT INTO persediaan (tanggal_transaksi,admin_id,picker_gudang_id,status) VALUES ('{$tanggal_transaksi}','{$admin_id}','{$picker_gudang_id}','1')");
    }

    // mendapatkan data persediaan exist berdasarkan barang id
    public function getBarangInPersediaan($barang_id = 0)
    {
        return DB::select("SELECT * FROM persediaan INNER JOIN persediaan_detail ON persediaan.persediaan_id = persediaan_detail.persediaan_id WHERE persediaan_detail.barang_id='{$barang_id}' AND persediaan.is_delete=0 AND persediaan.is_confirm=1");
    }

    // Hapus persediaan
    public function deletePersediaan($id = 0)
    {
        DB::statement("UPDATE persediaan SET persediaan.is_delete=1 WHERE persediaan.persediaan_id='$id'");
    }

    // Mengambil data id persediaan terakhir berdasarkan si pembuat ( admin )
    public function getLatestPersediaanId($status = 1)
    {
        // Dapatkan admin id yang membuat berbagai jenis transaksi ini 

        return collect(DB::select("SELECT * FROM persediaan WHERE persediaan.status={$status} AND persediaan.is_delete=0 ORDER BY persediaan.persediaan_id DESC LIMIT 1"))->first();
    }

    // Get form barang 
    public function getFormBarang()
    {
        return DB::select("SELECT *, admin.name as admins, picker_gudang.name as picker_gudangs FROM persediaan INNER JOIN user_login as admin ON persediaan.admin_id = admin.user_login_id INNER JOIN user_login as picker_gudang ON persediaan.picker_gudang_id = picker_gudang.user_login_id  WHERE persediaan.status=1 AND persediaan.is_delete=0");
    }

    // Get persediaan by id
    public function getPersediaanById($id = 0)
    {
        return collect(DB::select("SELECT * FROM persediaan WHERE persediaan.persediaan_id='{$id}'"))->first();
    }

    // Get persediaan detail by id
    public function getPersediaanDetailById($id = 0)
    {
        return DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$id}'");
    }

    // Untuk mendapatkan data form barang sebelum form ini sebelum dihapus
    public function getPreviousFormBarangBeforeDeleted($pesan_id = 0, $barang_id = 0)
    {
        return collect(DB::select("SELECT * FROM pesan INNER JOIN persediaan ON pesan.persediaan_id = persediaan.persediaan_id INNER JOIN persediaan_detail ON persediaan.persediaan_id = persediaan_detail.persediaan_id WHERE pesan.pesan_id < {$pesan_id} AND persediaan_detail.barang_id={$barang_id} AND persediaan.is_delete=0 ORDER BY pesan.pesan_id DESC LIMIT 1"))->first();
    }

    public function getPreviousFormBarangBeforeDeletedWithoutPesan($persediaan_id = 0, $barang_id = 0)
    {
        return collect(DB::select("SELECT * FROM persediaan INNER JOIN persediaan_detail ON persediaan.persediaan_id = persediaan_detail.persediaan_id WHERE persediaan.persediaan_id < {$persediaan_id} AND persediaan_detail.barang_id={$barang_id} AND persediaan.is_delete=0 ORDER BY persediaan.persediaan_id DESC LIMIT 1"))->first();
    }

    // Get form barang by picker
    public function getFormBarangByPicker()
    {
        $getPickerId = session()->get('login')['user_id'];

        return DB::select("SELECT *, admin.name as admins, picker_gudang.name as picker_gudangs FROM persediaan INNER JOIN user_login as admin ON persediaan.admin_id = admin.user_login_id INNER JOIN user_login as picker_gudang ON persediaan.picker_gudang_id = picker_gudang.user_login_id  WHERE persediaan.status=1 AND persediaan.picker_gudang_id='{$getPickerId}' AND persediaan.is_delete=0");
    }

    // Menambahkan sisa recovery pada persediaan detail ( preventif terhadap penghapusan form barang jika hal demikian terjadi )
    public function updatePersediaanDetailForSisaRecovery($persediaan_id = 0, $barang_id = 0, $jumlah = 0)
    {
        DB::statement("UPDATE persediaan_detail SET recovery_sisa='{$jumlah}' WHERE persediaan_detail.barang_id='{$barang_id}' AND persediaan_detail.persediaan_id='{$persediaan_id}'");
    }

    // Insert Persediaan Detail
    public function insertPersediaanDetail($dataFormBarangDetail = [])
    {
        // Get Latest Admin Persediaan Id
        $getLatestPersediaanId = $this->getLatestPersediaanId();

        foreach ($dataFormBarangDetail as $barang) {
            DB::statement("INSERT INTO persediaan_detail(persediaan_id,barang_id,barang_entry,sisa) VALUES('{$getLatestPersediaanId->persediaan_id}','{$barang}','0','0')");
        }
    }

    // Proses Penyesuaian Persediaan
    public function penyesuaianFormBarang($id = 0, $stokGudang = [], $barang_id = [])
    {
        for ($i = 0; $i < count($stokGudang); $i++) {
            DB::statement("UPDATE persediaan_detail SET sisa='{$stokGudang[$i]}' WHERE persediaan_detail.persediaan_id='{$id}' AND persediaan_detail.barang_id='{$barang_id[$i]}'");
        }
    }

    // Proses konfirmasi form barang
    public function konfirmasiFormBarang($id = 0)
    {
        DB::statement("UPDATE persediaan SET is_confirm='1' WHERE persediaan.persediaan_id='{$id}'");
    }

    // update setiap barang entry yang ada di dalam persediaan ( setelah membuat list order )
    public function updateBarangEntry($barang_id = [], $stok = [], $persediaan_id = 0)
    {
        for ($i = 0; $i < count($barang_id); $i++) {
            $includeListOrder = $stok[$i] == 0 ? 0 : 1;

            DB::statement("UPDATE persediaan_detail SET persediaan_detail.barang_entry='{$stok[$i]}', is_next={$includeListOrder} WHERE persediaan_detail.persediaan_id='{$persediaan_id}' AND persediaan_detail.barang_id='{$barang_id[$i]}'");
        }
    }

    // Konfirmasi persediaan setelah dibuat list order oleh admin
    public function konfirmasiFormBarangAdmin($persediaan_id = 0)
    {
        DB::statement("UPDATE persediaan SET persediaan.is_confirm_by_admin=1 WHERE persediaan.persediaan_id='{$persediaan_id}'");
    }

    // Cek apakah ada barang pada form pada tanggal setelah tanggal transaksi ini akan dilakukan
    public function checkPersediaanAfterThisDate($tanggal_transaksi = '', $barang_id = 0)
    {
        return DB::select("SELECT persediaan.persediaan_id as id_persediaan, persediaan.tanggal_transaksi as id_transaksi, barang.nm_barang as nama_barang , persediaan_detail.barang_id as id_barang, barang.jumlah FROM persediaan INNER JOIN persediaan_detail ON persediaan.persediaan_id = persediaan_detail.persediaan_id INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan.tanggal_transaksi > '{$tanggal_transaksi}' AND persediaan_detail.barang_id={$barang_id}  AND persediaan.is_delete=0 ORDER BY persediaan.tanggal_transaksi ASC");
    }

    // Cek apakah ada barang id yang hendak di tambahkan ke form barang ini, sedangkan di form barang sebelumnya sudah pernah ada barang tersebut namun belum disesuaikan 
    public function checkPersediaanExist($barang_id = 0)
    {
        return collect(DB::select("SELECT * FROM persediaan INNER JOIN persediaan_detail
        ON persediaan.persediaan_id = persediaan_detail.persediaan_id INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id
        WHERE persediaan.is_confirm=0 AND persediaan.is_delete=0 AND persediaan_detail.barang_id={$barang_id} OR persediaan.is_confirm_by_admin=0 AND persediaan.is_delete=0 AND persediaan_detail.barang_id={$barang_id}"))->first();
    }

    // Cek persediaan pada tanggal setelah form ini dibuat
    public function checkPersediaanByDateExist($tanggal_transaksi = '', $persediaan_id = 0, $barang_id = 0)
    {
        return DB::select("SELECT * FROM persediaan INNER JOIN persediaan_detail ON persediaan.persediaan_id = persediaan_detail.persediaan_id INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan.tanggal_transaksi >= '{$tanggal_transaksi}' AND persediaan.persediaan_id > {$persediaan_id} AND persediaan_detail.barang_id={$barang_id} AND persediaan.is_delete=0");
    }

    // Ubah semua stok barang entry di persediaan detail tersebut kembali menjadi 0
    public function resetBarangEntryPersediaanDetail($id = 0)
    {
        DB::statement("UPDATE persediaan_detail SET barang_entry=0 WHERE persediaan_detail.persediaan_id='{$id}'");
    }

    // Ubah confirm by admin table persediaan kembali menjadi default
    public function resetConfirmByAdminPersediaan($id = 0)
    {
        DB::statement("UPDATE persediaan SET is_confirm_by_admin=0 WHERE persediaan.persediaan_id='{$id}'");
    }

    // Mendapatkan barang di dalam persediaan spesifik
    public function getSpesificBarangInPersediaan($persediaan_id = 0, $barang_id = 0)
    {
        return collect(DB::select("SELECT * FROM persediaan_detail WHERE persediaan_detail.persediaan_id='{$persediaan_id}' AND persediaan_detail.barang_id='{$barang_id}'"))->first();
    }
}
