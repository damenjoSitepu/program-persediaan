<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kasus dengan 3 tanggal sama 
        // DB::table('pesan')->insert([
        //     'pesan_id'      => 1,
        //     'tanggal_pesan' => '2000-01-01',
        //     'supplier_id'   => 1,
        //     'admin_id'      => 1,
        //     'persediaan_id' => 1
        // ]);

        // DB::table('pesan')->insert([
        //     'pesan_id'      => 2,
        //     'tanggal_pesan' => '2000-01-01',
        //     'supplier_id'   => 1,
        //     'admin_id'      => 1,
        //     'persediaan_id' => 2
        // ]);

        // DB::table('pesan')->insert([
        //     'pesan_id'      => 3,
        //     'tanggal_pesan' => '2000-01-01',
        //     'supplier_id'   => 1,
        //     'admin_id'      => 1,
        //     'persediaan_id' => 3
        // ]);


        // Kasus dengan 3 tanggal berbeda 
        DB::table('pesan')->insert([
            'pesan_id'      => 1,
            'tanggal_pesan' => '2000-01-01',
            'supplier_id'   => 1,
            'admin_id'      => 1,
            'persediaan_id' => 1
        ]);

        DB::table('pesan')->insert([
            'pesan_id'      => 2,
            'tanggal_pesan' => '2000-01-02',
            'supplier_id'   => 1,
            'admin_id'      => 1,
            'persediaan_id' => 2
        ]);

        DB::table('pesan')->insert([
            'pesan_id'      => 3,
            'tanggal_pesan' => '2000-01-03',
            'supplier_id'   => 1,
            'admin_id'      => 1,
            'persediaan_id' => 3
        ]);





        // DB::table('pesan')->insert([
        //     'pesan_id'      => 1,
        //     'tanggal_pesan' => '2000-01-01',
        //     'supplier_id'   => 1,
        //     'admin_id'      => 1,
        //     'persediaan_id' => 1
        // ]);

        // DB::table('pesan')->insert([
        //     'pesan_id'      => 2,
        //     'tanggal_pesan' => '2000-01-02',
        //     'supplier_id'   => 1,
        //     'admin_id'      => 1,
        //     'persediaan_id' => 2
        // ]);

        // DB::table('pesan')->insert([
        //     'pesan_id'      => 3,
        //     'tanggal_pesan' => '2000-01-03',
        //     'supplier_id'   => 1,
        //     'admin_id'      => 1,
        //     'persediaan_id' => 3
        // ]);
    }
}
