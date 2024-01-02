@extends('components.layouts.master')
@section('content')


<div class="w-full min-h-[calc(100vh-300px)] flex flex-col items-center justify-center text-center p-5">
  <div class="w-full md:w-[800px]">
    <h1 class="font-bold text-3xl md:text-5xl md:leading-[65px]">
      Cek Pembayaran Anda Dengan Lebih Mudah
    </h1>
    <p class="font-medium text-lg md:text-xl mt-5">
      Ketikan Nama Anda pada search box dibawah ini untuk mengecek pembayaran anda
    </p>
  </div>
  <div class="w-full md:w-2/4 mx-auto mt-10">
    <form id="formSearchCustomer">
      <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
      <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input type="search" id="customerNameInput"
          class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          placeholder="Pelanggan..." required>
        <button type="submit"
          class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
      </div>
    </form>
  </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#formSearchCustomer').submit(function(e) {
      e.preventDefault();
      var name = $('#customerNameInput').val();
      var newUrl = '/cek-pembayaran/' + name;
      window.location.href = newUrl;
    });
  });
</script>
@endsection