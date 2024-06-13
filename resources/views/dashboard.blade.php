 <!-- Header dengan Logo -->
 <header>
    <nav class="navbar navbar-expand-lg bg-primary sticky-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('storage/logo2.png') }}" alt="Logo" width="150" class="d-inline-block align-text-top">
            </a>
            
            <!-- Toggler button for small screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item me-4">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                        <i class="fa-solid fa-gauge me-1"></i> 
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </li>
                <li class="nav-item">
                    <x-nav-link :href="route('index')" class="text-white">
                    <i class="fa-solid fa-earth-asia me-1"></i>
                        {{ __('Map') }}
                    </x-nav-link>
                </li>
            </ul>
        </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </nav>
</header>

    <!-- LAYOUT -->
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

    <!-- CAROUSEL -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="storage/carousel-1.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h1>Selamat Datang</h1>
            </div>
        </div>
        <div class="carousel-item">
            <img src="storage/carousel-2.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h2>Laporkan Gangguan Lalu Lintas</h2>
                <p>Buat laporan atas gangguan lalu lintas yang terjadi di seluruh area Kota Mataram</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="storage/carousel-3.jpeg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h2>Hati-Hati di Jalan!</h2>
                <p>Jangan lupa untuk selalu menjaga keselamatan dalam berkendara</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


    <!-- CONTENT -->
    <div class="container custom-container mt-3">
        <div class="row">
            <div class="col-md-8">
                <!-- Konten untuk rasio 2/3 -->
                <img src="storage/Panduan MTA.png" class="img-fluid mb-4" alt="Responsive image">
                
                <!-- Card Ringkasan Laporan -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title text-center mt-2"><b>Ringkasan Laporan Tahun 2024</b></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center">
                                <div class="alert alert-danger" role="alert">
                                    <h6><i class="fa-solid fa-flag"></i> Jumlah Laporan Masuk</h6>
                                    <p style="font-size: 50px">{{ $total_points }}</p>
                                </div>
                            </div>
                            <!-- Uncomment these sections if needed -->
                            <!--
                            <div class="col text-center">
                                <div class="alert alert-success" role="alert">
                                    <h4><i class="fa-solid fa-chart-line"></i> Total Polylines</h4>
                                    <p style="font-size: 40px">{{ $total_polylines }}</p>
                                </div>
                            </div>
                            <div class="col text-center">
                                <div class="alert alert-warning" role="alert">
                                    <h4><i class="fa-solid fa-shapes"></i> Total Polygon</h4>
                                    <p style="font-size: 40px">{{ $total_polygons }}</p>
                                </div>
                            </div>
                            -->
                        </div>
                        <!-- <hr>
                        <p class="mt-2">
                            <h4>Anda login sebagai <b>{{ Auth::user()->name }}</b> dengan email <i>{{ Auth::user()->email }}</i></h4>
                        </p> -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Konten untuk rasio 1/3 -->
                <div class="row row-cols-1 g-2">
                    <div class="col">
                        <img src="storage/7.png" class="img-fluid mb-1" alt="Image 1">
                    </div>
                    <div class="col">
                        <img src="storage/1.png" class="img-fluid mb-1" alt="Image 1">
                    </div>
                    <div class="col">
                        <img src="storage/2.png" class="img-fluid mb-1" alt="Image 2">
                    </div>
                    <div class="col">
                        <img src="storage/3.png" class="img-fluid mb-1" alt="Image 3">
                    </div>
                    <div class="col">
                        <img src="storage/4.png" class="img-fluid mb-1" alt="Image 4">
                    </div>
                    <div class="col">
                        <img src="storage/5.png" class="img-fluid mb-1" alt="Image 5">
                    </div>
                    <div class="col">
                        <img src="storage/6.png" class="img-fluid mb-1" alt="Image 6">
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- <div class="container py-12 mt-10">
    <div class="card shadow">
        <div class="card-header">
            <h2 class="card-title"> <b>Ringkasan Laporan Tahun 2024</b></h2>
        </div>
        <div class="card-body">
        <div class="row">
            <div class="col text-center">
            <div class="alert alert-danger" role="alert">
             <h4><i class="fa-solid fa-flag"></i> Jumlah Laporan Masuk </h4>
             <p style="font-size: 40px">{{ $total_points }}</p>
            </div>
            </div>
            <div class="col text-center">
            <div class="alert alert-success" role="alert">
             <h4><i class="fa-solid fa-chart-line"></i> Total Polylines</h4>
             <p style="font-size: 40px">{{ $total_polylines }}</p>
            </div>
            </div>
            <div class="col text-center">
            <div class="alert alert-warning" role="alert">
             <h4><i class="fa-solid fa-shapes"></i> Total Polygon</h4>
             <p style="font-size: 40px">{{ $total_polygons }}</p>
            </div>
            </div>
            <hr>
            <p class= mt-2>
            <h4>Anda login sebagai <b>{{ Auth::user()->name }}</b> dengan email <i>{{ Auth::user()->email }}</i></h4>
            </p>

        </div>
    </div>
    </div> -->

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-10 py-12"> <!-- Mengubah lebar kolom menjadi 10 -->
            <div class="card mb-0">
                <div class="card-body">
                    <h3 class="card-title text-danger mb-2 text-center font-weight-bold">NOMOR DARURAT</h3> <!-- Menambahkan font-weight-bold untuk membuat teks tebal -->
                    <p class="card-text text-dark text-center mb-3">Hubungi nomor darurat berikut dalam keadaan darurat:</p>
                    <div class="row justify-content-center"> <!-- Mengatur agar konten berada di tengah -->
                        <div class="col-sm-4 text-center "> <!-- Mengatur lebar kolom untuk konten -->
                            <a href="tel:110" class="btn btn-primary btn-number d-flex align-items-center justify-content-center" style="height: 100%;">
                                <span>Polisi: 110</span>
                            </a>
                        </div>
                        <div class="col-sm-4 text-center"> <!-- Mengatur lebar kolom untuk konten -->
                            <a href="tel:113" class="btn btn-primary btn-number d-flex align-items-center justify-content-center" style="height: 100%;">
                                <span>Pemadam Kebakaran: 113</span>
                            </a>
                        </div>
                        <div class="col-sm-4 text-center"> <!-- Mengatur lebar kolom untuk konten -->
                            <a href="tel:118" class="btn btn-primary btn-number d-flex align-items-center justify-content-center" style="height: 100%;">
                                <span>Ambulans: 118 atau 119</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-primary text-white">
                <img src="{{ asset('storage/logo1.png') }}" class="rounded me-2" alt="..." width="40px">
                <strong class="me-auto">Mataram Traffic Aware</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-center">
                Anda login sebagai <b>{{ Auth::user()->name }}</b> dengan email <i>{{ Auth::user()->email }}</i>
            </div>
        </div>
    </div>

    <!-- KATA-KATA MOTIVASI -->
         <blockquote class="blockquote text-center my-4">
         <p class="mb-0"><i class="fa-solid fa-quote-left"></i> <i>Sedikit kepedulian anda akan sangat membantu masyarakat pengguna jalan</i></p>
        </blockquote>

    <!-- FOOTER -->
    <footer class="bg-light text-black py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-1">Mataram Traffic Aware</h5>
                <ul class="list-unstyled">
                    <li>Yogyakarta</li>
                    <li>Email: edraelricadewi@mail.ugm.ac.id</li>
                    <li>Telepon/Whatsapp: +62 8113900165</li>
                </ul>
            </div>
            <div class="col-md-6">
            <div class="row align-items-center"> <!-- Baris untuk gambar kotak dan teks -->
                <div class="col-auto me-3"> <!-- Kolom untuk gambar kotak -->
                    <img src="storage/logo3.png" alt="" style="max-width: 150px;">
                </div>
                <div class="col"> <!-- Kolom untuk teks "Instansi" -->
                    <ul class="list-unstyled">
                        <li>Program Studi Sistem Informasi Geografis</li>
                        <li>Departemen Teknologi Kebumian</li>
                        <li>Sekolah Vokasi</li>
                        <li>Universitas Gadjah Mada</li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6">
                <img src="storage/logo2.png" alt="" class="img-fluid" style="max-width: 150px;">
            </div>
            <div class="col-md-6 text-md-end">
                <p>&copy; 2024 Edra Elricadewi</p>
            </div>
        </div>
    </div>
</footer>

     <!-- BOOTSTRAP JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastEl = document.getElementById('myToast');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    </script>

    <script>
        function callEmergency(number) {
            // Implementasi panggilan nomor darurat di sini
            console.log('Memanggil nomor darurat: ' + number);
            // Anda bisa menambahkan logika lain sesuai kebutuhan, misalnya:
            // window.location.href = 'tel:' + number;
        }
    </script>

</x-app-layout>
