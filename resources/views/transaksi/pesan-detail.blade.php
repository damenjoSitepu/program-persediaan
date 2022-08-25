
@if(Session::has('message'))
<div class="alert alert-success my-4" role="alert">
    {{ Session::get('message') }}
</div>
@endif

@php
    // Get Pesan Data
    $getPesanData = collect(DB::select("SELECT * FROM pesan WHERE pesan.pesan_id='{$id}'"))->first();

    $getInfo = DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$getPesanData->persediaan_id}' AND persediaan_detail.is_next='1'");
 
@endphp
<div class="d-flex w-100 mb-4 justify-content-between align-items-center">
  <h5 class="fw-bold text-primary d-inline-block"><i class="fas fa-list"></i> List Order ID: {{ $getPesanData->pesan_id   }}</h5>  
  <a href="{{ route('transaksi-data-sub-id',['sub' => 'detail-form-barang','id' => $getPesanData->persediaan_id]) }}" class="d-inline-block ms-4 btn btn-danger fw-bold text-light text-decoration-none rounded"><i class="fas fa-search-plus"></i> Lihat Form Barang List Order Ini</a>
</div>

<table class="table table-hover">
    <thead class="bg-primary text-light">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Nama Barang</th>
          <th scope="col">Stok Beli</th>
        </tr>
      </thead>
      <tbody>

        @foreach($getInfo as $info)
        <tr class="align-middle">
          <th scope="row">{{ $loop->iteration }}</th>
          <td class="fw-bold text-primary">{{ $info->nm_barang }}</td>
          <td class="fw-bold">{{ $info->barang_entry }}</td>
        </tr>
        @endforeach
      
      </tbody>
</table>