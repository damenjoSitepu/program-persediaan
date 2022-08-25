@php
    $getDetail = DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$id}'");

    $getInformation = collect(DB::select("SELECT * FROM persediaan INNER JOIN user_login ON persediaan.picker_gudang_id = user_login.user_login_id WHERE persediaan.persediaan_id='{$id}'"))->first();
   
@endphp

@if(Session::has('message'))
<div class="fs-6 alert alert-success my-4" role="alert">
    {{ Session::get('message') }}
</div>
@endif

<div class="d-flex w-100 mb-4 justify-content-between">
  <h3>Form Barang: {{ $getInformation->persediaan_id }}</h3>
  <button class="btn btn-success d-block w-25 fw-bold"><i class="fas fa-calendar"></i> {{ $getInformation->tanggal_transaksi }}</button>
</div>

<form action="{{ route('transaksi-extra/konfirmasi-form-barang',['id' => $id]) }}" method="POST">
    @csrf
<table class="table table-hover fs-6">
    <thead class="bg-primary text-light">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Nama Barang</th>
          @if($getInformation->is_confirm_by_admin == 0)
          <th scope="col">Stok Penyesuaian</th>
          @endif
        </tr>
      </thead>
      <tbody>

        @foreach($getDetail as $detail)
        <input type="hidden" name="barang_id[]" value="{{ $detail->barang_id }}">
        <tr class="align-middle">
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ $detail->nm_barang }}</td>
          @if($getInformation->is_confirm_by_admin == 0)
          <td class="w-25"><input type="text" name="sisa[]" value="{{$detail->sisa}}" class="form-control" id="exampleFormControlInput1" placeholder="Stok"></td>
          @endif
        </tr>
        @endforeach
      
      </tbody>
</table>

@if($getInformation->is_confirm_by_admin == 0)
<button class="btn btn-info fw-bold text-light"><i class="fas fa-check"></i> Sesuaikan Form Barang</button>
@else 
<a class="btn btn-danger fw-bold text-light"><i class="fas fa-check"></i> Penyesuaian Selesai</a>
@endif

</form>
