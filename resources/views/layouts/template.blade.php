<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <!-- LEAFLET CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <!-- BOOTSTRAP CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
     <!-- FONT AWESOME -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>

    </style>

    @yield('styles')
</head>

<body>
<nav class="navbar navbar-expand-lg bg-light sticky-top border-bottom border-body" data-bs-theme="light">
  <div class="container-fluid">
  <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('storage/logo2.png') }}" alt="Logo" width="150"class="d-inline-block align-text-top">
            </a>

    <!-- <a class="navbar-brand" href="#"><i class="fa-solid fa-map-location-dot"></i> {{$title}}</a> -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('index') }}"><i class="fa-solid fa-earth-asia"></i> Map</a>
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-table"></i> Tabel
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('table-point') }}">Point</a></li>
            <li><a class="dropdown-item" href="{{ route('table-polyline') }}">Polyline</a></li>
            <li><a class="dropdown-item" href="{{ route('table-polygon') }}">Polygon</a></li>

          </ul>
        </li> -->

        <li class="nav-item">
        <a class="nav-link" href="{{ route('table-point') }}">
          <i class="fa-solid fa-table"></i> Tabel Gangguan Lalu Lintas
        </a>
      </li>

        <li class="nav-item">
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#infoModal"><i class="fa-solid fa-circle-info"></i> Info</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        </li>

        @if (Auth::check())
        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <li class="nav-item">
          <button class="nav-link text-danger" type="submit"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </li>
        </form>

        @else
        <li class="nav-item">
          <a class="nav-link text-info" href="{{ route('login') }}"><i class="fa-solid fa-right-from-bracket"></i> Login</a>
        </li>
        @endif

      </ul>
    </div>
  </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
      <img src="{{ asset('storage/logo1.png') }}" class="rounded me-2" alt="..." width="40px">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Informasi Umum</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Tentang Aplikasi:</strong></p>
        <p>Aplikasi ini memberikan informasi terkini tentang gangguan lalu lintas di kota Mataram untuk meningkatkan keselamatan dan kelancaran berkendara.</p>
        
        <p><strong>Panduan Penggunaan:</strong></p>
        <p>Gunakan menu map untuk melihat peta interaktif dan laporkan gangguan.</p>
        
        <p><strong>Jenis Gangguan:</strong></p>
        <ul>
          <li>Kecelakaan Lalu Lintas</li>
          <li>Pohon Tumbang</li>
          <li>Jalan Rusak</li>
          <li>Pemeliharaan Jalan</li>
          <li>Penutupan Jalan</li>
          <li>Banjir/Genangan Air</li>
        </ul>
        
        <p><strong>Prosedur Pelaporan:</strong></p>
        <ol>
          <li>Temukan lokasi gangguan di peta.</li>
          <li>Isi formulir pelaporan dengan detail yang diperlukan.</li>
          <li>Kirim laporan.</li>
        </ol>
        
        <p><strong>Kontak Darurat:</strong></p>
        <ul>
          <li>Polisi: 110</li>
          <li>Pemadam Kebakaran: 113</li>
          <li>Layanan Darurat: 112</li>
          <!-- Tambahkan kontak darurat lain jika ada -->
        </ul>
        
        <p><strong>Panduan Keselamatan:</strong></p>
        <ul>
          <li>Hindari menggunakan ponsel saat mengemudi.</li>
          <li>Gunakan sabuk pengaman.</li>
          <li>Patuhi batas kecepatan dan aturan lalu lintas.</li>
          <li>Selalu beri jarak aman dengan kendaraan di depan Anda.</li>
          <li>Periksa kondisi kendaraan secara teratur.</li>
        </ul>
          </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      <!-- </div> -->
    </div>
  </div>
</div>

    <!-- <h1>This is Laravel Page, Welcome!</h1> -->
    @yield('content')

    <!-- LEAFLET JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" ></script>
    <!-- JQUERY --> 
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  
    @include('components.toast')

   @yield('script')
</body>
</html>