@extends('page.main.home')

@section('content')

<h3><i class="fas fa-money-bill text-primary"></i> Halaman Transaksi — 
    @if($sub == '' || $sub == 'form-barang')
    Form Barang <a href="{{ route('transaksi-data-sub',['sub' => 'form-barang-tambah']) }}" class="btn btn-success ms-2"><i class="fas fa-plus-circle"></i> Tambah Form Barang</a>
    @elseif($sub == 'form-barang-tambah')
    Tambah Form Barang <a href="{{ route('transaksi-data-sub',['sub' => 'form-barang']) }}" class="btn btn-danger ms-2"><i class="fas fa-arrow-to-right-bracket"></i> Kembali</a>
    @elseif($sub == 'detail-form-barang')
    Detail Form Barang <a href="{{ route('transaksi-data-sub',['sub' => 'form-barang']) }}" class="btn btn-danger ms-2"><i class="fas fa-arrow-to-right-bracket"></i> Kembali</a>
    @elseif($sub == 'daftar-pesan')
    List Order

    @elseif($sub == 'pesan-detail')
    List Order Detail <a href="{{ route('transaksi-data-sub',['sub' => 'daftar-pesan']) }}" class="btn btn-danger ms-2"><i class="fas fa-arrow-to-right-bracket"></i> Kembali</a>
    @elseif($sub == 'laporan-persediaan')
    Laporan Persediaan
    @endif</h3>
<hr class="my-4">

{{-- List Of Submenu --}}
<ul class="py-4 rounded border">
    <li class="list-unstyled d-inline-block">
        <a href="{{ route('transaksi-data-sub',['sub' => 'form-barang']) }}" class="{{ $sub == 'form-barang' || $sub == 'form-barang-tambah' || $sub == '' || $sub == 'detail-form-barang' || $sub == 'pegawai-ubah' ? 'link-active' : '' }} text-decoration-none {{ $sub == 'form-barang' || $sub == '' || $sub == 'form-barang-tambah' || $sub == 'detail-form-barang'  ? 'text-light' : 'text-secondary' }} px-4 py-2 rounded "><i class="fas fa-user-gear"></i> Form Barang</a>
    </li>

    <li class="list-unstyled d-inline-block">
        <a href="{{ route('transaksi-data-sub',['sub' => 'daftar-pesan']) }}" class="{{ $sub == 'daftar-pesan' || $sub == 'pesan-detail' ? 'link-active' : '' }} text-decoration-none {{ $sub == 'daftar-pesan' || $sub == 'pesan-detail' ? 'text-light' : 'text-secondary' }} px-4 py-2 rounded "><i class="fas fa-file"></i> List Order</a>
    </li>

    <li class="list-unstyled d-inline-block">
        <a href="{{ route('transaksi-data-sub',['sub' => 'laporan-persediaan']) }}" class="{{ $sub == 'laporan-persediaan' ? 'link-active' : '' }} text-decoration-none {{ $sub == 'laporan-persediaan' ? 'text-light' : 'text-secondary' }} px-4 py-2 rounded "><i class="fas fa-file-circle-check"></i> Laporan Persediaan</a>
    </li>
</ul>
{{-- End Of List Submenu --}}

<div class="sub-content my-4">
    @if($sub == '' || $sub == 'form-barang')
        @include('transaksi.form-barang')
    @elseif($sub == '' || $sub == 'form-barang-tambah')
        @include('transaksi.form-barang-tambah')
    @elseif($sub == '' || $sub == 'detail-form-barang')
        @include('transaksi.detail-form-barang')
    @elseif($sub == 'daftar-pesan')
        @include('transaksi.daftar-pesan')
    @elseif($sub == 'pesan-detail')
        @include('transaksi.pesan-detail')
    @elseif($sub == 'laporan-persediaan')
        @include('transaksi.laporan-persediaan')
    @endif
</div>

@endSection