<?php

use App\Http\Controllers\Auth\AuthPages;
use App\Http\Controllers\Auth\AuthProcess;
use App\Http\Controllers\Home\HomePages;
use App\Http\Controllers\Master\MasterPages;
use App\Http\Controllers\Master\MasterProcess;
use App\Http\Controllers\Transaksi\TransaksiPages;
use App\Http\Controllers\Transaksi\TransaksiProcess;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Beranda
Route::get('/', [HomePages::class, 'index']);
Route::get('/', [HomePages::class, 'index'])->name('homes');

// Master Data
Route::get('/master-data', [MasterPages::class, 'index'])->name('master');
Route::get('/master-data-sub/{sub}', [MasterPages::class, 'index'])->name('master-data-sub');
Route::get('/master-data-sub-id/{sub}/{id}', [MasterPages::class, 'index'])->name('master-data-sub-id');

// Master Data - Pegawai
Route::post('/master-data/buat-pegawai', [MasterProcess::class, 'index'])->name('master/buat-pegawai');
Route::get('/master-data/hapus-pegawai/{id}', [MasterProcess::class, 'hapus'])->name('master/hapus-pegawai');
Route::post('/master-data/ubah-pegawai/{id}', [MasterProcess::class, 'ubah'])->name('master/ubah-pegawai');
Route::get('/master-data/hapus-supplier/{id}', [MasterProcess::class, 'hapus'])->name('master/hapus-supplier');
Route::post('/master-data/buat-supplier', [MasterProcess::class, 'buatsupplier'])->name('master/buat-supplier');
Route::get('/master-data/hapus-supplier/{id}', [MasterProcess::class, 'hapussupplier'])->name('master/hapus-supplier');
Route::post('/master-data/ubah-supplier/{id}', [MasterProcess::class, 'ubahsupplier'])->name('master/ubah-supplier');
Route::get('/master-data/hapus-barang/{id}', [MasterProcess::class, 'hapusbarang'])->name('master/hapus-barang');
Route::post('/master-data/buat-barang', [MasterProcess::class, 'buatbarang'])->name('master/buat-barang');
Route::post('/master-data/ubah-barang/{id}', [MasterProcess::class, 'ubahbarang'])->name('master/ubah-barang');
Route::post('/master-data/ubah-barang-stok/{id}', [MasterProcess::class, 'ubahbarangstok'])->name('master/ubah-barang-stok');

// Transaksi
Route::get('/transaksi', [TransaksiPages::class, 'index'])->name('transaksi');
Route::get('/transaksi-data/hapus-form-barang/{id}', [TransaksiProcess::class, 'hapusformbarang'])->name('transaksi-data/hapus-form-barang');
Route::get('/transaksi-data/hapus-list-order/{id}', [TransaksiProcess::class, 'hapuslistorder'])->name('transaksi-data/hapus-list-order');
Route::get('/transaksi-data-sub/{sub}', [TransaksiPages::class, 'index'])->name('transaksi-data-sub');
Route::get('/transaksi-data-sub-id/{sub}/{id}', [TransaksiPages::class, 'index'])->name('transaksi-data-sub-id');
Route::post('/transaksi/buat-form-barang', [TransaksiProcess::class, 'index'])->name('transaksi/buat-form-barang');
Route::post('/transaksi/buat-list-order/{id}', [TransaksiProcess::class, 'buatlistorder'])->name('transaksi/buat-list-order');

// Transaksi Extra
Route::get('/transaksi-extra', [TransaksiPages::class, 'indexs'])->name('transaksi-extra');
Route::post('/transaksi-extra/konfirmasi-form-barang/{id}', [TransaksiProcess::class, 'konfirmasiformbarang'])->name('transaksi-extra/konfirmasi-form-barang');
Route::get('/transaksi-extra-data-sub/{sub}', [TransaksiPages::class, 'indexs'])->name('transaksi-extra-data-sub');
Route::get('/transaksi-extra-data-sub-id/{sub}/{id}', [TransaksiPages::class, 'indexs'])->name('transaksi-extra-data-sub-id');

// Autetifikasi
Route::get('/authentification', [AuthPages::class, 'index'])->name('authentification');
Route::post('/authentification/login', [AuthProcess::class, 'index'])->name('authentification/login');
Route::get('/authentification/logout', [AuthProcess::class, 'logout'])->name('authentification/logout');
