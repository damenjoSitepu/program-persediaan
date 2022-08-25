
@if(Session::has('message'))
<div class="alert alert-secondary my-4" role="alert">
    {!! Session::get('message') !!}
</div>
@endif

@if(count($getSupplier) == 0)
  <div class="error">
    <img class="w-25 m-auto d-block " src="{{ asset('assets/img/wrong.png') }}" alt="">
    <a class="btn btn-primary rounded m-auto d-block w-50 my-5 fw-bold" href="{{ route('master-data-sub',['sub' => 'supplier-tambah']) }}">Kami Tidak Dapat Menemukan Supplier Yang Anda Inginkan :(</a>
  </div>
@else 
  <table class="table table-hover">
    <thead class="bg-primary text-light">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Id Supplier</th>
          <th scope="col">Nama Supplier</th>
          <th scope="col">Alamat</th>
          <th scope="col">No. Telepon</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>

        @foreach($getSupplier as $supplier)
        <tr class="align-middle">
          <th scope="row">{{ $loop->iteration }}</th>
          <td class="fw-bold text-primary">
            @if(strlen($supplier->supplier_id) == 1)
            S-00{{ $supplier->supplier_id }}
            @elseif(strlen($supplier->supplier_id) == 2)
            S-0{{ $supplier->supplier_id }}
            @else 
            S-{{ $supplier->supplier_id }}
            @endif
          </td>
          <td>{{ $supplier->nm_supplier }}</td>
          <td>{{ $supplier->alamat }}</td>
          <td>{{ $supplier->no_telepon }}</td>
          <td>
            <a href="{{ route('master/hapus-supplier',['id' => $supplier->supplier_id]) }}" class="btn btn-danger text-decoration-none bg-danger rounded-pill me-2">Hapus</a>
            <a href="{{ route('master-data-sub-id',['sub' => 'supplier-ubah','id' => $supplier->supplier_id]) }}" class="btn btn-warning text-decoration-none rounded-pill">Ubah</a>
          </td>
        </tr>
        @endforeach
      
      </tbody>
  </table>
@endif

