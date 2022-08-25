<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserloginModel extends Model
{
    use HasFactory;

    // Get Userlogin
    public function getUserLoginByUsername($username = '')
    {
        return collect(DB::select("SELECT * FROM user_login WHERE user_login.username='{$username}'"))->first();
    }

    // Get user login by id
    public function getUserLoginById($id = '')
    {
        return collect(DB::select("SELECT * FROM user_login WHERE user_login.user_login_id='{$id}'"))->first();
    }

    // Get Recently user login
    public function getRecentlyUserLogin()
    {
        return collect(DB::select("SELECT * FROM user_login WHERE user_login.is_delete=0 AND user_login.user_login_id != 1 ORDER BY user_login.user_login_id DESC LIMIT 1"))->first();
    }

    // Get All User Login
    public function getAllUserLogin()
    {
        return DB::select("SELECT * FROM user_login INNER JOIN jabatan ON user_login.jabatan_id = jabatan.jabatan_id WHERE user_login.is_delete = 0 AND user_login.user_login_id != 1");
    }

    // Get All User Login picker
    public function getAllUserLoginPicker()
    {
        return DB::select("SELECT * FROM user_login INNER JOIN jabatan ON user_login.jabatan_id = jabatan.jabatan_id WHERE user_login.is_delete = 0 AND user_login.jabatan_id=2");
    }

    // Mendapatkan seluruh data user login berdasarkan nama depan calon user baru pegawai
    public function getUserLoginByFirstWord($column = 'name', $value = '')
    {
        return DB::select("SELECT * FROM user_login WHERE {$column} LIKE '%{$value}%'");
    }

    // Mengubah data user login ( pegawai / picker gudang )
    public function updateUserLogin($id = 0, $dataPegawai = [])
    {
        $name           = $dataPegawai['name'];
        $jabatan_id     = $dataPegawai['jabatan_id'];
        $password       = $dataPegawai['password'];

        DB::statement("UPDATE user_login SET name='{$name}', jabatan_id='{$jabatan_id}', password='{$password}' WHERE user_login.user_login_id='{$id}'");
    }

    // Membuat user login baru ( pegawai / picker gudang )
    public function insertUserLogin($dataPegawai = [])
    {
        $name           = $dataPegawai['name'];
        $username       = $dataPegawai['username'];
        $jabatan_id     = $dataPegawai['jabatan_id'];
        $password       = '123';

        DB::statement("INSERT INTO user_login(name,username,jabatan_id,password) VALUES('{$name}','{$username}','{$jabatan_id}','{$password}')");
    }

    // Hapus user login yang dihapus
    public function deleteUserLogin($user_login_id = '')
    {
        DB::statement("UPDATE user_login SET is_delete=1 WHERE user_login_id='{$user_login_id}'");
    }
}
