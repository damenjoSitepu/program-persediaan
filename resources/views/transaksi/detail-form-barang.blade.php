@php
    $getDetail = DB::select("SELECT * FROM persediaan_detail INNER JOIN barang ON persediaan_detail.barang_id = barang.barang_id WHERE persediaan_detail.persediaan_id='{$id}'");

    $getInformation = collect(DB::select("SELECT * FROM persediaan INNER JOIN user_login ON persediaan.picker_gudang_id = user_login.user_login_id WHERE persediaan.persediaan_id='{$id}'"))->first();
   
    if($getInformation->is_confirm_by_admin == 1){
      $getInformationPesan = collect(DB::select("SELECT * FROM pesan WHERE pesan.persediaan_id='{$getInformation->persediaan_id}'"))->first();
    }
    
@endphp

@if(Session::has('message'))
<div class="alert alert-success my-4" role="alert">
    {{ Session::get('message') }}
</div>
@endif

@if($getInformation->is_confirm_by_admin == 0)
<h5 class="fw-bold text-decoration-underline text-secondary">Form Barang ID: {{ $getInformation->persediaan_id }}</h5>
@else 
<div class="d-flex w-100 mb-4 justify-content-between align-items-center">
  <h5 class="fw-bold text-decoration-underline text-secondary d-inline-block">List Order ID: {{ $getInformationPesan->pesan_id   }}</h5>  
  <a href="{{ route('transaksi-data-sub-id',['sub' => 'pesan-detail','id' => $getInformationPesan->pesan_id]) }}" class="d-inline-block ms-4 btn btn-success fw-bold text-light text-decoration-none rounded"><i class="fas fa-search"></i> Lihat Informasi Barang Yang Dijadikan List Order</a>
</div>

@endif

<div class="d-flex w-100 mb-4 justify-content-between">
  <h3>Nama Picker Gudang: {{ $getInformation->name }}</h3>
  @if($getInformation->is_confirm == 0)
  <button class="btn btn-danger d-block w-25 fw-bold"><i class="fas fa-clock"></i> Menunggu Menyesuaikan</button>
  @else 
  <button class="btn btn-primary d-block w-25 fw-bold"><i class="fas fa-check"></i> Telah Disesuaikan</button>
  @endif
</div>

<form action="{{ route('transaksi/buat-list-order',['id' => $id]) }}" method="POST">
@csrf
<table class="table table-hover">
    <thead class="bg-primary text-light">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Nama Barang</th>
          @if($getInformation->is_confirm_by_admin == 1)
          <th scope="col">Stok Awal</th>
          @endif
          <th scope="col">Stok Akhir</th>
      
          @if($getInformation->is_confirm == 1)
          <th scope="col">Order Stok</th>
          @endif
        </tr>
      </thead>
      <tbody>

        @foreach($getDetail as $detail)
        <tr class="align-middle">
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ $detail->nm_barang }}</td>
          @if($getInformation->is_confirm_by_admin == 0)
          <td>{{ $detail->sisa }}</td>
          @else 
          <td>{{ $detail->sisa }}</td>
          <td>{{ $detail->sisa + $detail->barang_entry }}</td>
          @endif
          @if($getInformation->is_confirm == 1)
            @if($getInformation->is_confirm_by_admin == 0)
              <td class="w-25">
                <input type="hidden" name="barang_id[]" value="{{ $detail->barang_id }}">
                <input type="text" name="tambahsisa[]" value="0" class="form-control" id="exampleFormControlInput1" placeholder="Stok">
              </td>
            @else
              <td class="w-25">
                <input type="hidden" name="barang_id[]" value="{{ $detail->barang_id }}">
                <input type="hidden" name="oldtambahsisa[]" value="{{ $detail->barang_entry }}">
                <input type="text" name="tambahsisa[]" value="{{ $detail->barang_entry }}" class="form-control" id="exampleFormControlInput1" placeholder="Stok">
              </td>
            @endif
          @endif
        </tr>
        @endforeach
      </tbody>
</table>





@if($getInformation->is_confirm == 1)
<hr class="my-5">

<div class="row mb-4 mt-4">
  <div class="col-lg-5">
      <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Tanggal List Order Dibuat</label>
      @if($getInformation->is_confirm_by_admin == 0)
      <input type="date" name="tanggal_pesan" value="{{ old('tanggal_pesan') ? old('tanggal_pesan') : $getInformation->tanggal_transaksi }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Barang" >
      <small class="text-danger mt-2 d-block fw-bold"><i class="fas fa-triangle-exclamation"></i> Setelah Admin membuat list order terhadap form barang ini, maka anda tidak dapat mengubah lagi tanggal transaksi yang sudah ditetapkan.</small>
      @else 
      <input type="date" name="tanggal_pesan" readonly="readonly" value="{{ old('tanggal_pesan') ? old('tanggal_pesan') : $getPesanById->tanggal_pesan }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Barang" >
      <small class="text-danger mt-2 d-block fw-bold"><i class="fas fa-triangle-exclamation"></i> Anda Sudah Tidak Dapat Mengubah Lagi Tanggal List Order Ini.</small>
      @endif
      @error('tanggal_pesan')
      <small class="text-danger mt-2 d-block">{{ $message }}</small>
      @enderror
  </div>

  <div class="col-lg-5">
      <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Nama Supplier</label>
      @if($getInformation->is_confirm_by_admin == 0)
      <select class="form-select" name="supplier_id" aria-label="Default select example">
        <option value="0" selected>- Pilih Supplier -</option>
        @foreach($getSupplier as $supplier)
        <option value="{{ $supplier->supplier_id }}">{{ $supplier->nm_supplier }}</option>
        @endforeach
      </select>
      @else 
      <select class="form-select" name="supplier_id" aria-label="Default select example">
        <option value="0" selected>- Pilih Supplier -</option>
        @foreach($getSupplier as $supplier)
          @if($supplier->supplier_id == $getPesanById->supplier_id)
          <option selected="selected" value="{{ $supplier->supplier_id }}">{{ $supplier->nm_supplier }}</option>
          @else 
          <option value="{{ $supplier->supplier_id }}">{{ $supplier->nm_supplier }}</option>
          @endif
   
        @endforeach
      </select>
      @endif
     
      @error('supplier_id')
      <small class="text-danger mt-2 d-block">{{ $message }}</small>
      @enderror
  </div>
</div>

<div class="shadow p-3 rounded mt-4 text-center">
  @if($getInformation->is_confirm_by_admin == 0)
  <p>Anda akan membuat <span class="fw-bold text-primary">List Order</span> dari penyesuaian ketersediaan form barang ini. Mohon untuk memilih barang yang ingin anda jadikan <span class="fw-bold text-primary">List Order</span>.</p>
  <button class="btn btn-danger fw-bold my-3">Buat List Order</button>
  @else 
  <p>Anda sudah pernah membuat <span class="fw-bold text-primary">List Order</span> untuk form barang ini. Anda masih dapat memperbarui <span class="fw-bold text-primary">List Order</span> ini dengan cara mengklik tombol di bawah.</p>
  <button class="btn btn-primary fw-bold my-3">Perbarui List Order</button>
  @endif
</div>
@endif
</form>