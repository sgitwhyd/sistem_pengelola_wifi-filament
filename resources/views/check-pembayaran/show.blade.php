@extends('components.layouts.master')

@section('content')


@if ($userTransactions->isEmpty())
<div class="w-full min-h-screen flex items-center flex-col justify-center">
  <p class="text-center font-medium text-xl mb-5">Tidak Ditemukan Sejarah Pembayaran Customer {{ $name }}.</p>
  <a href="/cek-pembayaran">
    <button type="button"
      class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Kembali</button>
  </a>
</div>
@else
<div class="w-full min-h-[calc(100vh-300px)] flex flex-col justify-center p-5">
  <div class="w-full">
    <h1 class=" text-2xl">
      Sejarah Pembayaran Pelanggan <span class="font-bold">
        {{ $name }}
      </span>
    </h1>
  </div>
  <div class="flex flex-wrap gap-5 mt-10">
    @foreach($userTransactions as $item)
    <div
      class="w-full md:max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
        Nama Pelanggan :
        {{ $item->customer->name }}
      </h5>
      <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
        Status Pembayaran : @if($item->status === 'paid')
        <span
          class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Sudah
          Dibayar</span>
        @elseif($item->status === 'unpaid')
        <span
          class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
          Belum Dibayar
        </span>
        @elseif($item->status === 'pending')
        <span
          class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
          Menunggu Verifikasi
        </span>
        @endif
      </p>
      <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
        Pembayaran Bulan : {{ $item->payment_month }}
      </p>
      <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
        Nama Paket : {{ $item->paket }} Rp. {{ number_format($item->package_price, 0, ',', '.') }}
      </p>

      <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
        Tanggal Transaksi Dibuat : {{ $item->created_at->format('d-m-Y') }}
      </p>
      <a href="/{{$item->id}}/pdf" target="_blank"
        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Cetak Nota
        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 14 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M1 5h12m0 0L9 1m4 4L9 9" />
        </svg>
      </a>
    </div>

    @endforeach
  </div>
</div>
@endif



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