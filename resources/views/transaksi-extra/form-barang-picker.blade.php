@if(Session::has('message'))
<div class="alert alert-success my-4 fs-6" role="alert">
    {{ Session::get('message') }}
</div>
@endif

<div class="d-flex flex-wrap justify-content-between">
@foreach($getFormBarangByPicker as $fb)
<div class="card mb-5" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Form Barang ID: {{ $fb->persediaan_id }}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{ $fb->tanggal_transaksi }}</h6>
      <hr>
      @if($fb->status == 1)
      <small class="fs-6 text-success fw-bold rounded mb-3">Status: Untuk Pembelian</small>
      @endif
      <div class="fs-6">
        <p class="card-text text-primary fw-bold">Dibuat Oleh Admin:</p>
      <p class="card-text"><i class="fas fa-user-lock"></i> {{ $fb->admins }}</p>
      </div>
      <hr>
      
      <a href="{{ route('transaksi-extra-data-sub-id',['sub' => 'penyesuaian-form-barang-picker', 'id' => $fb->persediaan_id]) }}" class="badge {{ $fb->is_confirm_by_admin == 0 ? 'bg-primary' : 'bg-danger' }} text-decoration-none m-auto d-block fs-6">
        @if($fb->is_confirm_by_admin == 0)
        Lakukan Penyesuaian
        @else 
        Penyesuaian Selesai
        @endif
      </a>
    </div>
</div>
@endforeach
</div>