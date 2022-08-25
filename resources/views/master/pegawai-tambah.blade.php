<form action="{{ route('master/buat-pegawai') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Nama Pegawai</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Pegawai" >
            @error('name')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Jabatan</label>
            <select class="form-select" name="jabatan_id" aria-label="Default select example">
                <option value="0" selected>- Pilih Jabatan -</option>
                @foreach($getJabatan as $jabatan)
                <option value="{{ $jabatan->jabatan_id }}">{{ $jabatan->nama_jabatan }}</option>
                @endforeach
            </select>
            @error('jabatan_id')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    </div>
    
    <button class="my-4 btn btn-success"><i class="fas fa-floppy-disk"></i> Simpan</button>
</form>