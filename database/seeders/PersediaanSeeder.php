<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersediaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kasus persediaan dengan tiga tanggal sama 
        // DB::table('persediaan')->insert([
        //     'persediaan_id'         => 1,
        //     'tanggal_transaksi'     => '2000-01-01',
        //     'admin_id'              => '1',
        //     'picker_gudang_id'      => '2',
        //     'status'                => '1',
        //     'is_confirm'            => '1',
        //     'is_confirm_by_admin'   => '1',
        //     'is_delete'             => '0'
        // ]);

        // DB::table('persediaan')->insert([
        //     'persediaan_id'         => 2,
        //     'tanggal_transaksi'     => '2000-01-01',
        //     'admin_id'              => '1',
        //     'picker_gudang_id'      => '2',
        //     'status'                => '1',
        //     'is_confirm'            => '1',
        //     'is_confirm_by_admin'   => '1',
        //     'is_delete'             => '0'
        // ]);

        // DB::table('persediaan')->insert([
        //     'persediaan_id'         => 3,
        //     'tanggal_transaksi'     => '2000-01-01',
        //     'admin_id'              => '1',
        //     'picker_gudang_id'      => '2',
        //     'status'                => '1',
        //     'is_confirm'            => '1',
        //     'is_confirm_by_admin'   => '1',
        //     'is_delete'             => '0'
        // ]);



        // Kasus persediaan dengan tiga tanggal berbeda
        DB::table('persediaan')->insert([
            'persediaan_id'         => 1,
            'tanggal_transaksi'     => '2000-01-01',
            'admin_id'              => '1',
            'picker_gudang_id'      => '2',
            'status'                => '1',
            'is_confirm'            => '1',
            'is_confirm_by_admin'   => '1',
            'is_delete'             => '0'
        ]);

        DB::table('persediaan')->insert([
            'persediaan_id'         => 2,
            'tanggal_transaksi'     => '2000-01-02',
            'admin_id'              => '1',
            'picker_gudang_id'      => '2',
            'status'                => '1',
            'is_confirm'            => '1',
            'is_confirm_by_admin'   => '1',
            'is_delete'             => '0'
        ]);

        DB::table('persediaan')->insert([
            'persediaan_id'         => 3,
            'tanggal_transaksi'     => '2000-01-03',
            'admin_id'              => '1',
            'picker_gudang_id'      => '2',
            'status'                => '1',
            'is_confirm'            => '1',
            'is_confirm_by_admin'   => '1',
            'is_delete'             => '0'
        ]);



        // DB::table('persediaan')->insert([
        //     'persediaan_id'         => 1,
        //     'tanggal_transaksi'     => '2000-01-01',
        //     'admin_id'              => '1',
        //     'picker_gudang_id'      => '2',
        //     'status'                => '1',
        //     'is_confirm'            => '1',
        //     'is_confirm_by_admin'   => '1',
        //     'is_delete'             => '0'
        // ]);

        // DB::table('persediaan')->insert([
        //     'persediaan_id'         => 2,
        //     'tanggal_transaksi'     => '2000-01-02',
        //     'admin_id'              => '1',
        //     'picker_gudang_id'      => '2',
        //     'status'                => '1',
        //     'is_confirm'            => '1',
        //     'is_confirm_by_admin'   => '1',
        //     'is_delete'             => '0'
        // ]);

        // DB::table('persediaan')->insert([
        //     'persediaan_id'         => 3,
        //     'tanggal_transaksi'     => '2000-01-03',
        //     'admin_id'              => '1',
        //     'picker_gudang_id'      => '2',
        //     'status'                => '1',
        //     'is_confirm'            => '1',
        //     'is_confirm_by_admin'   => '1',
        //     'is_delete'             => '0'
        // ]);
    }
}
