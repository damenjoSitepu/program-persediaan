@if(Session::has('message'))
<div class="alert alert-secondary my-4" role="alert">
    {!! Session::get('message') !!}
</div>
@endif

<div class="d-flex flex-wrap justify-content-between">
@foreach($getFormBarang as $fb)
<div class="card mb-5" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Form Barang ID: {{ $fb->persediaan_id }}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{ $fb->tanggal_transaksi }}</h6>
      <hr>
      @if($fb->is_confirm_by_admin == 1)
      <small class="fw-bold rounded mb-3 badge bg-success">Status: List Order Selesai</small>
      @endif
      <p class="card-text text-primary fw-bold">Dibuat Oleh</p>
      <p class="card-text"><i class="fas fa-user-lock"></i> {{ $fb->admins }}</p>
      <p class="card-text text-danger fw-bold">Ditujukan Kepada</p>
      <p class="card-text"><i class="fas fa-user-gear"></i> {{ $fb->picker_gudangs }}
      @if($fb->is_confirm == 0)
        <small class="badge bg-danger">Belum Disesuaikan</small>
      @else 
        <small class="badge bg-primary">Sudah Disesuaikan</small>
      @endif
      </p>
      <hr>
      
      <a href="{{ route('transaksi-data-sub-id',['sub' => 'detail-form-barang', 'id' => $fb->persediaan_id]) }}" class="badge bg-primary text-decoration-none">Lihat Detail</a>
      @if($fb->is_confirm_by_admin == 0)
      <a href="{{ route('transaksi-data/hapus-form-barang',['id' => $fb->persediaan_id]) }}" class="badge bg-danger text-decoration-none ms-3">Hapus Form</a>
      @endif
    </div>
</div>
@endforeach
</div>