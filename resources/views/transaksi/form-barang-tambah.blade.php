<form action="{{ route('transaksi/buat-form-barang') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-5 mb-4">
            <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" value="{{ old('tanggal_transaksi') }}" class="form-control" id="exampleFormControlInput1" placeholder="Tanggal Transaksi" >
            @error('tanggal_transaksi')
            <small class="text-danger mt-2 d-block">{{ $message }}</small>
            @enderror     
    </div>

    <div class="col-lg-5 mb-4">
        <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Picker Gudang</label>
        <select class="form-select" name="picker_gudang_id" aria-label="Default select example">
            <option value="0" selected>- Pilih Picker Gudang -</option>
            @foreach($getPegawai as $pegawai)
              @if($pegawai->jabatan_id == 2)
            <option value="{{ $pegawai->user_login_id }}">{{ $pegawai->name }}</option>
              @endif
            @endforeach
        </select>
        @error('picker_gudang_id')
        <small class="text-danger mt-2 d-block">{{ $message }}</small>
        @enderror     
    </div>
    </div>
  

    <hr class="my-4">

    <label for="exampleFormControlInput1" class="form-label text-primary fw-bold">Daftar Pilihan Barang</label>

    <div class="d-flex flex-wrap justify-content-between">
        @foreach($getBarang as $barang)
        <div class="form-check shadow p-3 mx-3 mt-4 mb-4 fw-bold rounded text-center m-auto w-25" style="box-sizing: border-box;" >
            <input class="form-check-input" name="barang_id[]" type="checkbox" value="{{ $barang->barang_id }}" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              {{ $barang->nm_barang }}
            </label>
          </div>
        @endforeach
    </div>
    
    <button class="my-4 btn btn-success"><i class="fas fa-floppy-disk"></i> Kirimkan Form Barang</button>
</form>






{{-- <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
      Default checkbox
    </label>
  </div> --}}