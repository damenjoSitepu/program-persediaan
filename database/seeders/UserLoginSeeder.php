<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_login')->insert([
            'name'              => 'Naftalia Puspita Adas',
            'jabatan_id'        => 1,
            'username'          => 'phepy',
            'password'          => '123'
        ]);

        // DB::table('user_login')->insert([
        //     'name'              => 'Picker Gudang',
        //     'jabatan_id'        => 2,
        //     'username'          => 'picker',
        //     'password'          => '123'
        // ]);
    }
}
