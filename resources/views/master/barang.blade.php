
@if(Session::has('message'))
<div class="alert alert-secondary my-4" role="alert">
    {!! Session::get('message') !!}
</div>
@endif

@if(count($getBarang) == 0)
  <div class="error">
    <img class="w-25 m-auto d-block " src="{{ asset('assets/img/wrong.png') }}" alt="">
    <a class="btn btn-primary rounded m-auto d-block w-50 my-5 fw-bold" href="{{ route('master-data-sub',['sub' => 'barang-tambah']) }}">Kami Tidak Dapat Menemukan Barang Yang Anda Inginkan :(</a>
  </div>
@else 
  <table class="table table-hover">
    <thead class="bg-primary text-light">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Id Barang</th>
          <th scope="col">Nama Barang</th>
          <th scope="col">Satuan</th>
          <th scope="col">Jumlah Stok</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>

        @foreach($getBarang as $barang)
        <tr class="align-middle">
          <th scope="row">{{ $loop->iteration }}</th>
          <td class="fw-bold text-primary">
            @if(strlen($barang->barang_id) == 1)
            B-00{{ $barang->barang_id }}
            @elseif(strlen($barang->barang_id) == 2)
            B-0{{ $barang->barang_id }}
            @else 
            B-{{ $barang->barang_id }}
            @endif
            </td>
          <td>{{ $barang->nm_barang }}</td>
          <td>{{ $barang->satuan }}</td>
          <td class="fw-bold text-primary">{{ $barang->jumlah }}</td>
          <td>
            <a href="{{ route('master/hapus-barang',['id' => $barang->barang_id]) }}" class="btn btn-danger text-decoration-none bg-danger rounded-pill me-2">Hapus</a>
            <a href="{{ route('master-data-sub-id',['sub' => 'barang-ubah','id' => $barang->barang_id]) }}" class="btn btn-warning text-decoration-none rounded-pill">Ubah</a>
          </td>
        </tr>
        @endforeach
      
      </tbody>
  </table>
@endif


