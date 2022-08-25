<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kasus list order dengan 3 tanggal sama 
        DB::table('barang')->insert([
            'nm_barang'     => 'SD ( STAD dan DORF )',
            'satuan'        => 'Unit',
            'jumlah'        => 100
        ]);

        DB::table('barang')->insert([
            'nm_barang'     => 'BR ( BERNSTEIN )',
            'satuan'        => 'Unit',
            'jumlah'        => 100
        ]);

        DB::table('barang')->insert([
            'nm_barang'     => 'DZ ( DAZZLE )',
            'satuan'        => 'Unit',
            'jumlah'        => 100
        ]);

        DB::table('barang')->insert([
            'nm_barang'     => 'PTL ( PETRALOCK )',
            'satuan'        => 'Unit',
            'jumlah'        => 100
        ]);

        DB::table('barang')->insert([
            'nm_barang'     => 'HMS ( HOME SAFE )',
            'satuan'        => 'Unit',
            'jumlah'        => 100
        ]);
    }
}
