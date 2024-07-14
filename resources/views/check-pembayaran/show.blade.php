@extends('components.layouts.master')

@section('content')
@php
use Carbon\Carbon;

Carbon::setLocale('id_ID'); // Set Indonesian locale

@endphp
<div class="container flex flex-col h-[calc(100vh-300px)]">
  @if ($userTransactions->isEmpty())
  <div class="flex flex-col items-center justify-center w-full h-full">
    <p class="mb-5 text-xl font-medium text-center">Tidak Ditemukan Sejarah Pembayaran Customer {{ $name }}.</p>
    <a href="/cek-pembayaran">
      <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Kembali</button>
    </a>
  </div>
  @else
  <div class="w-full min-h-screen pt-20">
    <div class="w-full">
      <h1 class="text-2xl ">
        Riwayat Pembayaran Pelanggan <span class="font-bold">
          {{ $name }}
        </span>
      </h1>
    </div>
    <div class="flex flex-wrap gap-5 mt-10">
      <div class="relative w-full overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">
                No
              </th>
              <th scope="col" class="px-6 py-3">
                Nama Pelanggan
              </th>
              <th scope="col" class="px-6 py-3">
                Status Pembayaran
              </th>
              <th scope="col" class="px-6 py-3">
                Pembayaran Bulan
              </th>
              <th scope="col" class="px-6 py-3">
                Nama Paket
              </th>
              <th scope="col" class="px-6 py-3">
                Tanggal Transaksi Dibuat
              </th>
              <th scope="col" class="px-6 py-3">
                Action
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($userTransactions as $index => $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $index + 1 }}
              </th>
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                <p>
                  {{ $item->customer->name }}
                </p>
              </th>
              <td class="px-6 py-4">
                @if($item->status === 'paid')
                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Sudah
                  Dibayar</span>
                @elseif($item->status === 'unpaid')
                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                  Belum Dibayar
                </span>
                @elseif($item->status === 'pending')
                <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                  Menunggu Verifikasi
                </span>
                @endif
              </td>
              <td class="px-6 py-4">
                {{ Carbon::parse($item->payment_month)->translatedFormat('F')}}
              </td>
              <td class="px-6 py-4">
                {{ $item->paket }} Rp. {{ number_format($item->package_price, 0, ',', '.') }}
              </td>
              <td class="px-6 py-4">
                {{ Carbon::parse($item->created_at)->translatedFormat('d F Y')}}
              </td>
              <td class="px-6 py-4">
                @if($item->status === 'paid')
                <a href="{{ route('transaction.pdf.download', ['record' => $item->id]) }}" target="_blank" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  Cetak Nota
                </a>
                @endif
              </td>
            </tr>
            @endforeach
        </table>
      </div>
      {{ $userTransactions->links() }}


    </div>
  </div>
  @endif
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