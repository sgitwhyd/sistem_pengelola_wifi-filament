@extends('components.layouts.master')

@section('content')
@if($customerFound)
<div class="w-full">
  <h1 class="w-full text-xl font-bold md:text-3xl">
    Sebelum Anda menyelesaikan pembayaran, mohon luangkan waktu sejenak untuk meneliti kembali detail pembayaran Anda. Hal ini penting untuk memastikan bahwa semua informasi yang Anda masukkan sudah akurat dan lengkap.
  </h1>
  <p class="text-gray-800">
Kami ingin memastikan kelancaran transaksi Anda dan menghindari kesalahpahaman di kemudian hari.
  </p>
  <form class="w-full mt-5" action="{{ route('pembayaran.store', [
    'name' => $customer->name,
  ]) }}" enctype="multipart/form-data" method="POST">
    @csrf
    <h1 class="text-2xl font-bold">
      Detail Pelanggan
    </h1>
    <div class="grid grid-cols-2 gap-5 mt-5 md:grid-cols-2">
      <div>
        <h1 class="text-xl font-semibold">
          Nama Customer
        </h1>
        <h2 class="text-lg font-medium">
          {{ $customer->name }}
        </h2>
      </div>
      <div>
        <h1 class="text-xl font-semibold">
          Alamat
        </h1>
        <h2 class="text-lg font-medium">
          {{ $customer->alamat }}
        </h2>
      </div>
      <div>
        <h1 class="text-xl font-semibold">
          Layanan Wifi Terdaftar
        </h1>
        <h2 class="text-lg font-medium">
          {{ $customer->paket->name }} - Rp {{ number_format($customer->paket->price, 0,0) }}
        </h2>
      </div>
      <div>
        <h1 class="text-xl font-semibold">
          Pembayaran Terakhir
        </h1>
        <h2 class="text-lg font-medium">
          @if($customer->transactions->isEmpty())
          Belum Ada Pembayaran
          @else
          {{ $customer->transactions->last()->payment_month }}
          @endif
        </h2>
      </div>
      <div>
        <h1 class="text-xl font-semibold">
          Status Pembayaran Terakhir
        </h1>
        <h2 class="text-lg font-medium">
          @if($customer->transactions->isEmpty())
          Belum Ada Pembayaran
          @else
          @php
          $status = $customer->transactions->last()->status;
          $color;
          $value;
          switch ($status) {
          case 'paid':
          $color = 'bg-green-100 text-green-800';
          $value = 'Lunas';
          break;
          case 'unpaid':
          $color = 'bg-red-100 text-red-800';
          $value = 'Belum Lunas';
          break;
          default:
          $color = 'bg-gray-100 text-gray-800';
          $value = 'Menunggu Verifikasi';
          break;
          }

          @endphp
          <span class="{{ $color }} font-medium me-2 px-2.5 py-0.5 rounded">
            {{ $value }}
          </span>
          @endif
        </h2>
      </div>
    </div>
    @if($customerAlreadyPay && $detailPayment->status === 'pending')
    <div class="flex flex-col items-center justify-center mt-5 space-y-4">
      <h1 class="max-w-xl text-2xl font-semibold text-center">
        Anda sudah melakukan pembayaran. Jika status pembayaran belum berubah, silakan hubungi admin
      </h1>
      <p class="text-lg">
        Cek Status Pembayaran Pada Link Berikut
      </p>
      <a href="{{ route('cek-pembayaran.show', ['user' => $customer->name]) }}" class="px-5 py-3 font-semibold text-white bg-blue-500 rounded-lg">
        Cek Pembayaran</a>
    </div>
    @else
    @if($detailPayment->payment_month === date('F'))
    <div class="flex flex-col items-center justify-center mt-5 space-y-4">
      <h1 class="max-w-xl text-2xl font-semibold text-center">
        Anda sudah melakukan pembayaran Bulan ini. Jika status pembayaran belum berubah, silakan hubungi admin
      </h1>
      <p class="text-lg">
        Cek Status Pembayaran Pada Link Berikut
      </p>
      <a href="{{ route('cek-pembayaran.show', ['user' => $customer->name]) }}" class="px-5 py-3 font-semibold text-white bg-blue-500 rounded-lg">
        Cek Pembayaran</a>
    </div>
    @else
    <h1 class="mt-5 text-2xl font-bold">
      Nomor Rekening Tersedia
    </h1>
    <p>
      Silakan pilih salah satu nomor rekening yang tersedia untuk melakukan pembayaran
    </p>
    <div class="grid grid-cols-2 gap-5 mt-3 md:grid-cols-3">
      @foreach($banks as $bank)
      <div class="grid items-center justify-center h-32 grid-cols-3 p-3 bg-white border border-gray-300 rounded-lg">
        <div class="flex flex-col items-center justify-center md:flex-row">
          <img src="{{ asset('storage/' . $bank->image) }}" alt="bank logo image" class="object-contain w-20 h-20">
        </div>
        <div class="col-span-2">
          <h1 class="text-lg font-semibold">
            {{ $bank->name }}
          </h1>
          <h2 class="text-lg font-medium">
            {{ $bank->nomor_rekening }}
          </h2>
        </div>
      </div>
      @endforeach
    </div>
    <h1 class="mt-5 text-2xl font-bold">
      Detail Pembayaran
    </h1>
    <div class="grid grid-cols-1 gap-5 mt-3">
      <div>
        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
          Pilih Bulan
        </label>
        <select id="month" name="month" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
          <option selected>Pilih Bulan Pembayaran</option>
          <option value="Januari">Januari</option>
          <option value="Februari">Februari</option>
          <option value="Maret">Maret</option>
          <option value="April">April</option>
          <option value="Mei">Mei</option>
          <option value="Juni">Juni</option>
          <option value="Juli">Juli</option>
          <option value="Agustus">Agustus</option>
          <option value="September">September</option>
          <option value="Oktober">Oktober</option>
          <option value="November">November</option>
          <option value="Desember">Desember</option>
        </select>
      </div>
      <div>
        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
          Upload Bukti Pembayaran
        </label>
        <input type="file" name="image" class="filepond" accept="image/*" required />
      </div>
    </div>
    <div class="mt-5">
      <h1 class="text-xl font-semibold">
        Total Tagihan
      </h1>
      <h2 class="text-lg font-medium">
        Rp. 200.000
      </h2>
    </div>
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mt-5">
      Submit Pembayaran
    </button>
    @endif
    @endif
  </form>
</div>
@else
<div class="flex flex-col items-center justify-center w-full min-h-screen">
  <p class="mb-5 text-xl font-medium text-center">
    Nama Customer Tidak Terdaftar
  </p>
  <a href="{{ route('pembayaran.index') }}">
    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Kembali</button>
  </a>
</div>
@endif
@endsection
@section('scripts')
<script>
  // Get a reference to the file input element
  const inputElement = document.querySelector('input[type="file"]');

  // Create a FilePond instance
  const pond = FilePond.create(inputElement, {
    acceptedFileTypes: ['image/*'],
    allowMultiple: false,
    fileValidateTypeDetectType: (source, type) =>
      new Promise((resolve, reject) => {
        // Do custom type detection here and return with promise
        resolve(type);
      }),
  });
</script>
@endsection