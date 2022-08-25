<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('supplier')->insert([
            'nm_supplier'   => 'Aria Starla',
            'alamat'        => 'Jln. Pangandaran',
            'no_telepon'    => '08292839238'
        ]);

        DB::table('supplier')->insert([
            'nm_supplier'   => 'Tari Puspita Sari',
            'alamat'        => 'Jln. Raden',
            'no_telepon'    => '09302329098'
        ]);

        DB::table('supplier')->insert([
            'nm_supplier'   => 'Mitha Tri Anjani',
            'alamat'        => 'Jln. Patrisia',
            'no_telepon'    => '093023298391'
        ]);

        DB::table('supplier')->insert([
            'nm_supplier'   => 'Himawari',
            'alamat'        => 'Jln. Kedutaan Bandung',
            'no_telepon'    => '0928280910290'
        ]);
    }
}
