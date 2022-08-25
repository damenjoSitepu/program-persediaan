<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersediaanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kasus persediaan dengan 3 tanggal sama
        DB::table('persediaan_detail')->insert([
            'persediaan_id'         => 1,
            'barang_id'             => 1,
            'barang_entry'          => 50,
            'sisa'                  => 100,
            'recovery_sisa'         => 200,
            'is_next'               => 1
        ]);

        DB::table('persediaan_detail')->insert([
            'persediaan_id'         => 2,
            'barang_id'             => 1,
            'barang_entry'          => 75,
            'sisa'                  => 75,
            'recovery_sisa'         => 150,
            'is_next'               => 1
        ]);

        DB::table('persediaan_detail')->insert([
            'persediaan_id'         => 3,
            'barang_id'             => 1,
            'barang_entry'          => 25,
            'sisa'                  => 175,
            'recovery_sisa'         => 150,
            'is_next'               => 1
        ]);








        // DB::table('persediaan_detail')->insert([
        //     'persediaan_id'         => 1,
        //     'barang_id'             => 1,
        //     'barang_entry'          => 25,
        //     'sisa'                  => 50,
        //     'recovery_sisa'         => 200,
        //     'is_next'               => 1
        // ]);

        // DB::table('persediaan_detail')->insert([
        //     'persediaan_id'         => 2,
        //     'barang_id'             => 1,
        //     'barang_entry'          => 50,
        //     'sisa'                  => 75,
        //     'recovery_sisa'         => 75,
        //     'is_next'               => 1
        // ]);

        // DB::table('persediaan_detail')->insert([
        //     'persediaan_id'         => 3,
        //     'barang_id'             => 1,
        //     'barang_entry'          => 75,
        //     'sisa'                  => 125,
        //     'recovery_sisa'         => 125,
        //     'is_next'               => 1
        // ]);
    }
}
