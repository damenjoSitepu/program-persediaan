@extends('page.main.home')

@section('content')

<h3><i class="fas fa-cogs text-primary"></i> Halaman Master Data — 
    @if($sub == '' || $sub == 'pegawai')
    Pegawai <a href="{{ route('master-data-sub',['sub' => 'pegawai-tambah']) }}" class="btn btn-success ms-2"><i class="fas fa-plus-circle"></i> Tambah Pegawai</a>
    @elseif($sub == 'pegawai-tambah')
    Form Tambah Pegawai <a href="{{ route('master-data-sub',['sub' => 'pegawai']) }}" class="btn btn-danger ms-2"><i class="fas fa-arrow-to-right-bracket"></i> Kembali</a>
    @elseif($sub == 'pegawai-ubah')
    Form Ubah Pegawai <a href="{{ route('master-data-sub',['sub' => 'pegawai']) }}" class="btn btn-danger ms-2"><i class="fas fa-arrow-to-right-bracket"></i> Kembali</a>
    @elseif($sub == 'supplier')
        Supplier <a href="{{ route('master-data-sub',['sub' => 'supplier-tambah']) }}" class="btn btn-success ms-2"><i class="fas fa-plus-circle"></i> Tambah Supplier</a>
    @elseif($sub == 'supplier-tambah')
        Form Tambah Supplier <a href="{{ route('master-data-sub',['sub' => 'supplier']) }}" class="btn btn-danger ms-2"><i class="fas fa-arrow-to-right-bracket"></i> Kembali</a>
    @elseif($sub == 'supplier-ubah')
        Form Ubah Supplier <a href="{{ route('master-data-sub',['sub' => 'supplier']) }}" class="btn btn-danger ms-2"><i class="fas fa-arrow-to-right-bracket"></i> Kembali</a>
    @elseif($sub == 'barang')
        Barang <a href="{{ route('master-data-sub',['sub' => 'barang-tambah']) }}" class="btn btn-success ms-2"><i class="fas fa-plus-circle"></i> Tambah Barang</a>
    @elseif($sub == 'barang-tambah')
        Form Tambah Barang <a href="{{ route('master-data-sub',['sub' => 'barang']) }}" class="btn btn-danger ms-2"><i class="fas fa-arrow-to-right-bracket"></i> Kembali</a>
    @elseif($sub == 'barang-ubah')
        Form Ubah Barang <a href="{{ route('master-data-sub',['sub' => 'barang']) }}" class="btn btn-danger ms-2"><i class="fas fa-arrow-to-right-bracket"></i> Kembali</a>
    @endif</h3>
<hr class="my-4">

{{-- List Of Submenu --}}
<ul class="py-4 rounded border">
    <li class="list-unstyled d-inline-block">
        <a href="{{ route('master-data-sub',['sub' => 'pegawai']) }}" class="{{ $sub == 'pegawai' || $sub == '' || $sub == 'pegawai-tambah' || $sub == 'pegawai-ubah' ? 'link-active' : '' }} text-decoration-none {{ $sub == 'pegawai' || $sub == '' || $sub == 'pegawai-tambah' || $sub == 'pegawai-ubah' ? 'text-light' : 'text-secondary' }} px-4 py-2 rounded "><i class="fas fa-user-gear"></i> Pegawai</a>
    </li>
    <li class="list-unstyled d-inline-block">
        <a href="{{ route('master-data-sub',['sub' => 'supplier']) }}" class="{{ $sub == 'supplier' || $sub == 'supplier-tambah' || $sub == 'supplier-ubah' ? 'link-active' : '' }} text-decoration-none {{ $sub == 'supplier' || $sub == 'supplier-tambah' || $sub == 'supplier-ubah' ? 'text-light' : 'text-secondary' }} px-4 py-2 rounded "><i class="fas fa-user-check"></i> Supplier</a>
    </li>
    <li class="list-unstyled d-inline-block">
        <a href="{{ route('master-data-sub',['sub' => 'barang']) }}" class="{{ $sub == 'barang' || $sub == 'barang-tambah' || $sub == 'barang-ubah' ? 'link-active' : '' }} text-decoration-none {{ $sub == 'barang' || $sub == 'barang-tambah' || $sub == 'barang-ubah' ? 'text-light' : 'text-secondary' }} px-4 py-2 rounded "><i class="fas fa-boxes"></i> Barang</a>
    </li>
</ul>
{{-- End Of List Submenu --}}

<div class="sub-content my-4">
    @if($sub == '' || $sub == 'pegawai')
        @include('master.pegawai')
    @elseif($sub == 'supplier')
        @include('master.supplier')
    @elseif($sub == 'barang')
        @include('master.barang')
    @elseif($sub == 'barang-tambah')
        @include('master.barang-tambah')
    @elseif($sub == 'pegawai-tambah')
        @include('master.pegawai-tambah')
    @elseif($sub == 'pegawai-ubah')
        @include('master.pegawai-ubah')
    @elseif($sub == 'supplier-tambah')
        @include('master.supplier-tambah')
    @elseif($sub == 'supplier-ubah')
        @include('master.supplier-ubah')
    @elseif($sub == 'barang-ubah')
        @include('master.barang-ubah')
    @endif
</div>

@endSection