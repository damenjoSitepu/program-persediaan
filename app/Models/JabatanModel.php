<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JabatanModel extends Model
{
    use HasFactory;

    // Get Data Jabatan
    public function getJabatan()
    {
        return DB::select("SELECT * FROM jabatan");
    }
}
