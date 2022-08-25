<div class="card w-100">
    <img style="width: 100%; height: 300px; object-fit: contain;" src="{{ asset('assets/img/home.png') }}" class="card-img-top" alt="Home Picture">
    <div class="card-body text-center mb-4">
      <h2 class="card-title text-primary"><i class="fas fa-home"></i> Beranda</h2>
      <p class="card-text">Selamat datang di Web Applikasi persediaan sederhana kami <span class="text-danger fw-bold">Picker Gudang </span> <span class="text-primary fw-bold">{{ session()->get('login')['name'] }}</span>.</p>
      <a href="#" class="btn btn-primary"><i class="fas fa-cogs"></i> Master Data</a>
    </div>
  </div>