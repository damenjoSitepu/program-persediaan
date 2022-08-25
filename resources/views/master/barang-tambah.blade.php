<form action="{{ route('master/buat-barang') }}" method="POST">
    @csrf
    <div class="row mb-4">
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Nama Barang</label>
            <input type="text" name="nm_barang" value="{{ old('nm_barang') }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Barang" >
            @error('nm_barang')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Nama Satuan</label>
            <input type="text" name="satuan" value="{{ old('satuan') }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Satuan Barang" >
            @error('satuan')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="w-25">
        <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Jumlah Stok</label>
        <input type="text" name="jumlah" value="{{ old('jumlah') }}" class="form-control" id="exampleFormControlInput1" placeholder="Jumlah Stok" >
        @error('jumlah')
        <small class="text-danger mt-2 d-block">{{ $message }}</small>
        @enderror
    </div>
    
    <button class="my-4 btn btn-success"><i class="fas fa-floppy-disk"></i> Simpan</button>
</form>