
@if(Session::has('message'))
<div class="alert alert-secondary my-4" role="alert">
    {!! Session::get('message') !!}
</div>
@endif

<table class="table table-hover">
    <thead class="bg-primary text-light">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Kode List Order</th>
          <th scope="col">Tanggal Pesan</th>
          <th scope="col">Supplier</th>
          <th scope="col">Admin</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>

        @foreach($getPesan as $pesan)
        <tr class="align-middle">
          <th scope="row">{{ $loop->iteration }}</th>
          <td class="fw-bold text-primary text-center">{{ $pesan->pesan_id }}</td>
          <td class="fw-bold text-primary">{{ $pesan->tanggal_pesan }}</td>
          <td class="fw-bold">{{ $pesan->nm_supplier }}</td>
          <td class="fw-bold">{{ $pesan->admin_name }}</td>
          <td> 
            <a href="{{ route('transaksi-data-sub-id',['sub' => 'detail-form-barang', 'id' => $pesan->persediaan_id]) }}" class="btn btn-primary text-decoration-none">Lihat Form Barang</a>
            <a href="{{ route('transaksi-data-sub-id',['sub' => 'pesan-detail','id' => $pesan->pesan_id]) }}" class="btn btn-info text-light text-decoration-none rounded">Detail</a>
            <a href="{{ route('transaksi-data/hapus-list-order',['id' => $pesan->pesan_id]) }}" class="btn btn-danger text-decoration-none bg-danger rounded me-2">Hapus</a></td>
          
        </tr>
        @endforeach
      
      </tbody>
</table>