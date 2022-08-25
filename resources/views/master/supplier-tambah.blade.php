<form action="{{ route('master/buat-supplier') }}" method="POST">
    @csrf
    <div class="row mb-4">
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Nama Supplier</label>
            <input type="text" name="nm_supplier" value="{{ old('nm_supplier') }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Supplier" >
            @error('nm_supplier')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">No. Telepon</label>
            <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="form-control" id="exampleFormControlInput1" placeholder="No. Telepon" >
            @error('no_telepon')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="w-50">
        <label for="exampleFormControlTextarea1" class="form-label text-primary fw-bold">Alamat</label>
        <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3">{{ old('alamat') }}</textarea>
        @error('alamat')
        <small class="text-danger mt-2 d-block">{{ $message }}</small>
        @enderror
    </div>
    
    <button class="my-4 btn btn-success"><i class="fas fa-floppy-disk"></i> Simpan</button>
</form>