<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SupplierModel extends Model
{
    use HasFactory;

    // Get All Supplier
    public function getAllSupplier()
    {
        return DB::select("SELECT * FROM supplier WHERE supplier.is_delete=0");
    }

    // Get Recently Supplier
    public function getRecentlySupplier()
    {
        return collect(DB::select("SELECT * FROM supplier WHERE supplier.is_delete=0 ORDER BY supplier.supplier_id DESC LIMIT 1"))->first();
    }

    // Get Supplier Data By Id
    public function getSupplierById($id = 0)
    {
        return collect(DB::select("SELECT * FROM supplier WHERE supplier.supplier_id='{$id}'"))->first();
    }

    // Menambahkan data baru supplier
    public function insertSupplier($dataSupplier = [])
    {
        $nm_supplier    = $dataSupplier['nm_supplier'];
        $alamat         = $dataSupplier['alamat'];
        $no_telepon     = $dataSupplier['no_telepon'];

        DB::statement("INSERT INTO supplier(nm_supplier,alamat,no_telepon) VALUES('{$nm_supplier}','{$alamat}','{$no_telepon}')");
    }

    // Menghapus data supplier
    public function deleteSupplier($id = 0)
    {
        DB::statement("UPDATE supplier SET supplier.is_delete=1 WHERE supplier.supplier_id='{$id}'");
    }

    // Mengubah data supplier
    public function updateSupplier($id = 0, $dataSupplier = [])
    {
        $nm_supplier    = $dataSupplier['nm_supplier'];
        $alamat         = $dataSupplier['alamat'];
        $no_telepon     = $dataSupplier['no_telepon'];

        DB::statement("UPDATE supplier SET nm_supplier='{$nm_supplier}', alamat='{$alamat}', no_telepon='{$no_telepon}' WHERE supplier.supplier_id='{$id}'");
    }
}
