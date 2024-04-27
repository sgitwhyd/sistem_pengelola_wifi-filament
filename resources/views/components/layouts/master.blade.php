<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">

  <meta name="application-name" content="{{ config('app.name') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name') }}</title>
  <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
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

<body class="antialiased ">
  <nav class="bg-white border-gray-200 dark:bg-gray-900 max-w-screen-xl mx-auto">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="/">
        @include('filament.admin.logo', ['company_name' => $company_name, 'company_logo' => $company_logo, ])
      </a>
      <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
      <div class="hidden w-full md:block md:w-auto" id="navbar-default">
        <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
          <li>
            <a href="{{ route('pembayaran.index') }}" class="block py-2 px-3  bg-blue-700 rounded md:bg-transparent text-blue-500  md:p-0 dark:text-white md:dark:text-blue-500 {{ request()->routeIs(['pembayaran.index', 'pembayaran.show']) ? ' text-blue-500' : ' text-gray-900' }} " aria-current="page">Pembayaran</a>
          </li>
          <li>
            <a href="{{ route('cek-pembayaran.index') }}" class="block py-2 px-3  bg-blue-700 rounded md:bg-transparent text-blue-500  md:p-0 dark:text-white md:dark:text-blue-500 {{ request()->routeIs(['cek-pembayaran.index', 'cek-pembayaran.show']) ? ' text-blue-500' : ' text-gray-900' }} " aria-current="page">Cek Pembayaran</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <main class="p-3 md:p-5 w-full md:max-w-screen-xl md:mx-auto">
    @yield('content')
  </main>
  <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
  <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
  <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
  <script>
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    FilePond.setOptions({
      server: {
        url: '/upload',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      }
    })
  </script>
  @yield('scripts')
  @filamentScripts
  @vite('resources/js/app.js')
</body>

</html>