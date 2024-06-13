<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Mataram Traffic Aware</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

        <!-- Import your custom CSS file -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
        .custom-container {
            max-width: 1000px; /* Ubah sesuai kebutuhan */
        }

        /* Ganti warna teks menjadi hitam */
        .text-dark {
            color: black !important;
        }

        /* Ganti warna latar belakang tombol */
        .btn-primary {
            background-color: #000000;
            border-color: #000000;
        }

        /* Ganti warna teks tombol */
        .btn-primary:hover {
            background-color: #ff0000;
            border-color: #ff0000;
        }

        /* Mengatur tinggi maksimum carousel */
        #carouselExampleCaptions img {
            max-height: 500px; /* Atur tinggi maksimum sesuai kebutuhan */
            object-fit: cover; 
        }

        h1, h2, h3, h4, h5 {
            font-weight: bold;
            /* font-style: italic; */
        }

        /* Ukuran heading spesifik */
        h1 {
            font-size: 2.5rem; /* 40px */
        }

        h2 {
            font-size: 2rem; /* 32px */
        }

        h3 {
            font-size: 1.75rem; /* 28px */
        }

        h4 {
            font-size: 1.5rem; /* 24px */
        }

        h5 {
            font-size: 1.25rem; /* 20px */
        }

        h6 {
            font-size: 1rem; /* 16px */
        }

        /* Styling untuk elemen blockquote */
        blockquote {
            padding: 10px 20px;
            font-weight: bold;
            margin: 20px 0;
            font-size: 1.25rem;
            /* border-left: 10px solid #007bff; */
            background-color: #BA8585;
            color: #ffffff;
        }

        /* CSS to make the navbar sticky */
        .navbar.sticky-top {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000; /* Ensure it's above other content */
        }

    </style>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Page Heading -->
            <!-- @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif -->

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
