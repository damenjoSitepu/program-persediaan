@extends('page.main.home')

@section('content')

<h3><i class="fas fa-money-bill text-primary fs-6"></i> Halaman Transaksi — 
    @if($sub == 'form-barang-picker' || $sub == '')
    Form Ketersediaan Barang 
    @elseif($sub == 'penyesuaian-form-barang-picker')
    Penyesuaian Barang Oleh Picker Gudang <a href="{{ route('transaksi-extra-data-sub',['sub' => 'form-barang-picker']) }}" class="btn btn-danger ms-2"><i class="fas fa-arrow-to-right-bracket"></i> Kembali</a>
    @endif
<hr class="my-4">

{{-- List Of Submenu --}}
<ul class="py-4 rounded border">
    <li class="list-unstyled d-inline-block">
        <a href="{{ route('transaksi-extra-data-sub',['sub' => 'form-barang-picker']) }}" class="{{ $sub == 'form-barang-picker' || $sub == 'penyesuaian-form-barang-picker' || $sub == '' ? 'link-active' : '' }} text-decoration-none fs-6 {{ $sub == 'form-barang-picker' || $sub == 'penyesuaian-form-barang-picker' || $sub == '' ? 'text-light' : 'text-secondary' }} px-4 py-2 rounded "><i class="fas fa-user-gear"></i> Form Ketersediaan Barang</a>
    </li>

</ul>
{{-- End Of List Submenu --}}

<div class="sub-content my-4">
    @if($sub == '' || $sub == 'form-barang-picker')
        @include('transaksi-extra.form-barang-picker')
    @elseif($sub == 'penyesuaian-form-barang-picker')
        @include('transaksi-extra.penyesuaian-form-barang-picker')
    @endif
</div>

@endSection