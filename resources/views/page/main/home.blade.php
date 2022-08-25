<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
  </head>
  <body>

    {{-- Menu Bar --}}
    <nav class="navbar navbar-expand-lg bg-primary">
      <div class="container">
        <a style="font-size: 1.5em;" class="navbar-brand text-light" href="#"><i class="fas fa-boxes"></i>&nbsp; Persediaan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>

    {{-- Sidebar and content ( left and right side ) --}}
<div class="contents d-flex">
  {{-- Sidebar --}}
  <div class="col-lg-2 p-3 border-end">
      <a class="{{ $title == 'Beranda' ? 'link-active' : '' }} text-decoration-none p-3 rounded {{ $title == 'Beranda' ? 'text-light' : 'text-secondary' }} w-100 d-block m-auto" href="{{ route('homes') }}"><i class="fas fa-home"></i>&nbsp; Beranda</a>

      @if(session()->get('login')['jabatan_id'] == 1)
      <a class="{{ $title == 'Master Data' ? 'link-active' : '' }} text-decoration-none p-3 rounded {{ $title == 'Master Data' ? 'text-light' : 'text-secondary' }} w-100 d-block m-auto" href="{{ route('master') }}"><i class="fas fa-cogs"></i>&nbsp; Master Data</a>

      <a class="{{ $title == 'Transaksi' ? 'link-active' : '' }} text-decoration-none p-3 rounded {{ $title == 'Transaksi' ? 'text-light' : 'text-secondary' }} w-100 d-block m-auto" href="{{ route('transaksi') }}"><i class="fas fa-money-bill"></i>&nbsp; Transaksi</a>
      @else 
      <a class="{{ $title == 'Transaksi' ? 'link-active' : '' }} text-decoration-none p-3 rounded {{ $title == 'Transaksi' ? 'text-light' : 'text-secondary' }} w-100 d-block m-auto" href="{{ route('transaksi-extra') }}"><i class="fas fa-cogs"></i>&nbsp; Transaksi</a>
      @endif

      <a class="text-decoration-none p-3 rounded text-secondary w-100 d-block m-auto" href="{{ route('authentification/logout') }}"><i class="fas fa-arrow-right-from-bracket"></i>&nbsp; Keluar</a>
  </div>

  {{-- Content --}}
  <div class="col-lg-10 p-5">
    @yield('content')
  </div>
</div>
{{-- End sidebar and content --}}

    


    
     <!-- Bottom Source -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
     <script src="https://kit.fontawesome.com/fbc67db110.js" crossorigin="anonymous"></script>
     <script src="{{ asset('assets/js/logic.js') }}"></script>
     <script>
  </body>
</html>