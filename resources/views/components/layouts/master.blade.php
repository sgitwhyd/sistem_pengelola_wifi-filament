<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">

  <meta name="application-name" content="{{ config('app.name') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name') }}</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <style>
    [x-cloak] {
      display: none !important;
    }
  </style>

  @filamentStyles
  @vite('resources/css/app.css')
</head>

@php

$company = app\models\Company::first();
$company_name = $company->name;
$company_logo = $company->logo;
@endphp

<body class="flex flex-col justify-between w-full min-h-screen mx-auto antialiased">
  <nav class="w-full mx-auto bg-white border-gray-200 shadow-md dark:bg-gray-900">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl p-4 mx-auto">
      <a href="/">
        @include('filament.admin.logo', ['company_name' => $company_name, 'company_logo' => $company_logo, ])
      </a>
      <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center justify-center w-10 h-10 p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false" id="hamburger">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
      <div class="hidden w-full md:block md:w-auto" id="navbar-default">
        <ul class="flex flex-col p-4 mt-4 font-medium border border-gray-100 rounded-lg md:p-0 bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
          <li>
            <a href="{{ route('pembayaran.index') }}" class="block py-2 px-3  bg-blue-700 rounded md:bg-transparent text-blue-500  md:p-0 dark:text-white md:dark:text-blue-500 {{ request()->routeIs(['pembayaran.index', 'pembayaran.show']) ? ' text-blue-500' : ' text-gray-900' }} " aria-current="page">Pembayaran</a>
          </li>
          <li>
            <a href="{{ route('cek-pembayaran.index') }}" class="block py-2 px-3  bg-blue-700 rounded md:bg-transparent text-blue-500  md:p-0 dark:text-white md:dark:text-blue-500 {{ request()->routeIs(['cek-pembayaran.index', 'cek-pembayaran.show']) ? ' text-blue-500' : ' text-gray-900' }} " aria-current="page">Cek Pembayaran</a>
          </li>
          <li>
            <a href="/admin/login" class="block px-3 py-2 rounded md:bg-transparent md:p-0 dark:text-white md:dark:text-blue-500 " aria-current="page">
              Login
            </a>
          </li>
        </ul>
      </div>
      <div class="hidden w-full md:w-auto" id="navbar-mobile">
        <ul class="flex flex-col p-4 mt-4 font-medium bg-white">
          <li class="">
            <a href="{{ route('pembayaran.index') }}" class="block py-2 px-3  border-b-gray-600  rounded md:bg-transparent text-blue-500  md:p-0 dark:text-white md:dark:text-blue-500 {{ request()->routeIs(['pembayaran.index', 'pembayaran.show']) ? ' text-blue-500' : ' text-gray-900' }} " aria-current="page">Pembayaran</a>
          </li>
          <li>
            <a href="{{ route('cek-pembayaran.index') }}" class="block py-2 px-3   rounded md:bg-transparent text-blue-500  md:p-0 dark:text-white md:dark:text-blue-500 {{ request()->routeIs(['cek-pembayaran.index', 'cek-pembayaran.show']) ? ' text-blue-500' : ' text-gray-900' }} " aria-current="page">Cek Pembayaran</a>
          </li>
          <li>
            <a href="/admin/login" class="block px-3 py-2 text-blue-500 rounded md:bg-transparent md:p-0 dark:text-white md:dark:text-blue-500 " aria-current="page">
              Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <main class="container max-w-screen-xl p-5 mx-auto">
    @yield('content')
  </main>
  <x-footer />
  <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
  <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
  <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
  <script>
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    FilePond.setOptions({
      server: {
        process: '{{ route("upload") }}',
        revert: '{{ route("revert") }}',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      }
    })
  </script>
  @yield('scripts')
  @filamentScripts
  @vite('resources/js/app.js')
  <script>
    const url = window.location.href
    const companyTitle = document.getElementById('logo_text')
    const companyLogo = document.getElementById('company_logo')

    companyLogo.classList.remove('hidden')
    companyLogo.classList.add('w-10')
    companyLogo.classList.add('md:w-[64px]')
    companyTitle.classList.add('md:text-lg')

    $(document).ready(function() {
      $('.maps iframe').prop('width', '100%');
      $('.maps iframe').prop('loading', 'lazy');

      $('#hamburger').click(function() {
        $('#navbar-mobile').toggle();
      });
    });

    function wifiReservation(data) {
      const template = `Halo Fanayu Daya Network saya ingin memasang paket ${data}.`;
      const url = `https://wa.me/{{ $company->no_telp }}?text=${template}`;
      window.open(url, '_blank');
    }
  </script>
</body>

</html>