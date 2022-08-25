<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangModel extends Model
{
    use HasFactory;

    // Get All Barang
    public function getAllBarang()
    {
        return DB::select("SELECT * FROM barang WHERE is_delete=0");
    }

    // Get barang by id
    public function getBarangById($id = 0)
    {
        return collect(DB::select("SELECT * FROM barang WHERE barang.barang_id='{$id}'"))->first();
    }

    // Get Recently Barang
    public function getRecentlyBarang()
    {
        return collect(DB::select("SELECT * FROM barang WHERE barang.is_delete=0 ORDER BY barang.barang_id DESC LIMIT 1"))->first();
    }

    // Insert Barang
    public function insertBarang($dataBarang = [])
    {
        $nm_barang      = $dataBarang['nm_barang'];
        $satuan         = $dataBarang['satuan'];
        $jumlah         = $dataBarang['jumlah'];

        DB::statement("INSERT INTO barang(nm_barang,satuan,jumlah) VALUES('{$nm_barang}','{$satuan}','{$jumlah}')");
    }

    // Delete barang
    public function deleteBarang($id = 0)
    {
        DB::statement("UPDATE barang SET barang.is_delete=1 WHERE barang.barang_id='{$id}'");
    }

    // update barang stok
    public function updateBarangStok($id = 0, $dataBarang = [])
    {
        $jumlah = $dataBarang['jumlah'];

        DB::statement("UPDATE barang SET jumlah='{$jumlah}' WHERE barang.barang_id='{$id}'");
    }

    // update barang stok 2
    public function updateBarangStoks($id = 0, $jumlah = 0)
    {
        DB::statement("UPDATE barang SET jumlah='{$jumlah}' WHERE barang.barang_id='{$id}'");
    }

    // Update Barang
    public function updateBarang($id = 0, $dataBarang = [])
    {
        $nm_barang  = $dataBarang['nm_barang'];
        $satuan     = $dataBarang['satuan'];

        DB::statement("UPDATE barang SET nm_barang='{$nm_barang}', satuan='{$satuan}' WHERE barang.barang_id='{$id}'");
    }

    // Penyesuaian stok barang setelah picker gudang menyelesaikan form barang
    public function penyesuaianFormBarang($barang_id = 0, $stok = 0)
    {
        DB::statement("UPDATE barang SET jumlah='{$stok}' WHERE barang.barang_id='{$barang_id}'");

        // for ($i = 0; $i < count($barang_id); $i++) {
        //     DB::statement("UPDATE barang SET jumlah='{$stok[$i]}' WHERE barang.barang_id='{$barang_id[$i]}'");
        // }
    }

    // menambahkan atau mengurangi stok barang 
    public function tambahKurangStokBarang($barang_id = 0, $stok = 0, $symbol = "+")
    {
        DB::statement("UPDATE barang SET jumlah = jumlah {$symbol} {$stok} WHERE barang.barang_id='{$barang_id}'");
    }

    // Menambahkan stok barang setelah membuat list order
    public function tambahStokBarang($barang_id = [], $stok = [])
    {
        for ($i = 0; $i < count($barang_id); $i++) {
            DB::statement("UPDATE barang SET jumlah = jumlah + {$stok[$i]} WHERE barang.barang_id='{$barang_id[$i]}'");
        }
    }

    public function tambahStokBarangs($barang_id = 0, $stok = 0)
    {
        DB::statement("UPDATE barang SET jumlah = jumlah + {$stok} WHERE barang.barang_id='{$barang_id}'");
    }

    // Mengurangis stok barang setelah mengupdate list order
    public function kurangStokBarang($barang_id = [], $stok = [])
    {
        for ($i = 0; $i < count($barang_id); $i++) {
            DB::statement("UPDATE barang SET jumlah = jumlah - {$stok[$i]} WHERE barang.barang_id='{$barang_id[$i]}'");
        }
    }

    public function kurangStokBarangs($barang_id = 0, $stok = 0)
    {
        DB::statement("UPDATE barang SET jumlah = jumlah - {$stok} WHERE barang.barang_id='{$barang_id}'");
    }
}
