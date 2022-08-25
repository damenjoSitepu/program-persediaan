<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PesanModel extends Model
{
    use HasFactory;

    // Get all pesan
    public function getAllPesan()
    {
        return DB::select("SELECT *, supplier_alias.nm_supplier as supplier_name, admin_alias.name as admin_name FROM pesan INNER JOIN supplier as supplier_alias ON pesan.supplier_id = supplier_alias.supplier_id INNER JOIN user_login as admin_alias ON pesan.admin_id = admin_alias.user_login_id INNER JOIN persediaan ON pesan.persediaan_id = persediaan.persediaan_id ORDER BY persediaan.persediaan_id ASC, persediaan.tanggal_transaksi ASC");
    }

    // Get pesan by id
    public function getPesanById($id = 0)
    {
        return collect(DB::select("SELECT * FROM pesan INNER JOIN persediaan ON pesan.persediaan_id = persediaan.persediaan_id WHERE pesan.persediaan_id='{$id}'"))->first();
    }

    public function getPesanByPesanId($pesan_id = 0)
    {
        return collect(DB::select("SELECT * FROM pesan INNER JOIN persediaan ON pesan.persediaan_id = persediaan.persediaan_id WHERE pesan.pesan_id='{$pesan_id}'"))->first();
    }


    // Proses update pesan 
    public function updatePesan($id = 0, $dataPesan = [])
    {
        $tanggal_pesan = $dataPesan['tanggal_pesan'];
        $admin_id = $dataPesan['admin_id'];
        $supplier_id = $dataPesan['supplier_id'];
        $persediaan_id = $dataPesan['persediaan_id'];

        DB::statement("UPDATE pesan SET tanggal_pesan='{$tanggal_pesan}', admin_id='{$admin_id}', supplier_id='{$supplier_id}', persediaan_id='{$persediaan_id}' WHERE pesan.persediaan_id='{$id}'");
    }

    // Proses insert pesan
    public function insertPesan($dataPesan = [])
    {
        $tanggal_pesan = $dataPesan['tanggal_pesan'];
        $admin_id = $dataPesan['admin_id'];
        $supplier_id = $dataPesan['supplier_id'];
        $persediaan_id = $dataPesan['persediaan_id'];

        DB::statement("INSERT INTO pesan(tanggal_pesan,admin_id,supplier_id,persediaan_id) VALUES ('{$tanggal_pesan}','{$admin_id}','{$supplier_id}','{$persediaan_id}')");
    }

    // Proses delete pesan
    public function deletePesan($id = 0)
    {
        DB::statement("DELETE FROM pesan WHERE pesan.pesan_id='{$id}'");
    }
}
