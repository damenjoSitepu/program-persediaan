<form action="{{ route('master/ubah-supplier',['id' => $pegawaiId]) }}" method="POST">
    @csrf
    <div class="row mb-4">
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Nama Supplier</label>
            <input type="text" name="nm_supplier" value="{{ old('nm_supplier') ? old('nm_supplier') : $getSupplierById->nm_supplier }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Pegawai" >
            @error('nm_supplier')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">No. Telepon</label>
            <input type="text" name="no_telepon" value="{{ old('no_telepon') ? old('no_telepon') : $getSupplierById->no_telepon }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Pegawai" >
            @error('no_telepon')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="w-50">
        <label for="exampleFormControlTextarea1" class="form-label text-primary fw-bold">Alamat</label>
        <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3">{{ old('alamat') ? old('alamat') : $getSupplierById->alamat }}</textarea>
        @error('alamat')
        <small class="text-danger mt-2 d-block">{{ $message }}</small>
        @enderror
    </div>
    
    <button class="my-4 btn btn-warning text-light"><i class="fas fa-file-pen"></i> Ubah</button>
</form>