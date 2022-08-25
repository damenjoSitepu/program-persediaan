<form action="{{ route('master/ubah-pegawai',['id' => $pegawaiId]) }}" method="POST">
    @csrf
    <div class="row mb-4">
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Nama Pegawai</label>
            <input type="text" name="name" value="{{ old('name') ? old('name') : $getPegawaiById->name }}" class="form-control" id="exampleFormControlInput1" placeholder="Nama Pegawai" >
            @error('name')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Jabatan</label>
            <select class="form-select" name="jabatan_id" aria-label="Default select example">
                @foreach($getJabatan as $jabatan)
                    @if($jabatan->jabatan_id == $getPegawaiById->jabatan_id)
                        <option selected="selected" value="{{ $jabatan->jabatan_id }}">{{ $jabatan->nama_jabatan }}</option>
                    @else 
                        <option value="{{ $jabatan->jabatan_id }}">{{ $jabatan->nama_jabatan }}</option>
                    @endif
                @endforeach
            </select>
            @error('jabatan_id')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Username</label>
            <input type="text" readonly="readonly" value="{{ old('username') ? old('username') : $getPegawaiById->username }}" class="form-control" id="exampleFormControlInput1" placeholder="Username" >
            @error('username')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="col-lg-5">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Password</label>
            <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="Password">
            @error('password')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror
        </div>
    </div>
    
    <button class="my-4 btn btn-warning text-light"><i class="fas fa-file-pen"></i> Ubah</button>
</form>