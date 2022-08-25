
<h4 class="text-secondary mb-3">Informasi Umum</h4>
<hr class="my-4">

<form action="{{ route('master/ubah-barang',['id' => $pegawaiId]) }}" method="POST">
    @csrf
    <div class="row mb-4">
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Nama Barang</label>
            <input type="text" name="nm_barang" value="{{ old('nm_barang') ? old('nm_barang') : $getBarangById->nm_barang }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Barang" >
            @error('nm_barang')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Nama Satuan</label>
            <input type="text" name="satuan" value="{{ old('satuan') ? old('satuan') : $getBarangById->satuan }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Satuan Barang" >
            @error('satuan')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    </div>

    
    <button class="my-4 btn btn-warning text-light"><i class="fas fa-file-pen"></i> Ubah Informasi</button>
</form>

<h4 class="text-secondary mb-3 mt-4">Informasi Stok</h4>
<hr class="my-4">

<form action="{{ route('master/ubah-barang-stok',['id' => $pegawaiId]) }}" method="POST">
    @csrf
        <div class="w-50">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Jumlah Stok</label>
            @if(count($checkBarangInPersediaan) == 0)
                <input type="text"  name="jumlah" value="{{ old('jumlah') ? old('jumlah') : $getBarangById->jumlah }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Barang" >
            @else 
                <input type="text" disabled="disabled"  name="jumlah" value="{{ old('jumlah') ? old('jumlah') : $getBarangById->jumlah }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Barang" >
            @endif
            @error('jumlah')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
     
        @if(count($checkBarangInPersediaan) == 0)
        <button class="my-4 btn btn-warning text-light"><i class="fas fa-file-pen"></i> Ubah Stok</button>
        @else 
        <a class="my-4 btn btn-danger text-light"><i class="fas fa-circle-exclamation"></i> Anda Tidak Bisa Mengubah Stok Ini!</a>
        @endif
    
</form>