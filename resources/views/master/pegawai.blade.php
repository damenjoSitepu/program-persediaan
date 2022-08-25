
@if(Session::has('message'))
<div class="alert alert-secondary my-4" role="alert">
    {!! Session::get('message') !!}
</div>
@endif

@if(count($getPegawai) == 0)
  <div class="error">
    <img class="w-25 m-auto d-block " src="{{ asset('assets/img/wrong.png') }}" alt="">
    <a class="btn btn-primary rounded m-auto d-block w-75 my-5 fw-bold" href="{{ route('master-data-sub',['sub' => 'pegawai-tambah']) }}">Kami Tidak Dapat Menemukan Anggota Pegawai Yang Anda Inginkan :(</a>
  </div>
@else 
  <table class="table table-hover">
    <thead class="bg-primary text-light">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Id Pegawai</th>
          <th scope="col">Nama Pegawai</th>
          <th scope="col">Jabatan</th>
          <th scope="col">Username</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>

        @foreach($getPegawai as $pegawai)
        <tr class="align-middle">
          <th scope="row">{{ $loop->iteration }}</th>
          <td class="fw-bold text-primary">
            @if(strlen($pegawai->user_login_id) == 1)
            E-00{{ $pegawai->user_login_id }}
            @elseif(strlen($pegawai->user_login_id) == 2)
            E-0{{ $pegawai->user_login_id }}
            @else 
            E-{{ $pegawai->user_login_id }}
            @endif
          </td>
          <td>{{ $pegawai->name }}</td>
          <td>{{ $pegawai->nama_jabatan }}</td>
          <td class="fw-bold text-primary">{{ $pegawai->username }}</td>
          <td>
            <a href="{{ route('master/hapus-pegawai',['id' => $pegawai->user_login_id]) }}" class="btn btn-danger text-decoration-none bg-danger rounded-pill me-2">Hapus</a>
            <a href="{{ route('master-data-sub-id',['sub' => 'pegawai-ubah','id' => $pegawai->user_login_id]) }}" class="btn btn-warning text-decoration-none rounded-pill">Ubah</a>
          </td>
        </tr>
        @endforeach
      
      </tbody>
  </table>
@endif


