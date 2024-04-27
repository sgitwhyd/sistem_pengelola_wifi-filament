@extends('components.layouts.master')

@section('content')

<div class="w-full min-h-[calc(100vh-300px)] flex flex-col items-center md:items-start p-5">
  <h1 class="font-bold text-3xl w-full md:max-w-6xl md:text-center">
    Pastikan untuk memeriksa kembali detail pembayaran Anda sebelum melanjutkan. Kami ingin memastikan semua informasi sudah benar
  </h1>
  <form class="mt-5 w-full" action="{{ route('pembayaran.store') }}" enctype="multipart/form-data" method="POST">
    @csrf
    <h1 class="text-2xl font-bold">
      Detail Pelanggan
    </h1>
    <div class="grid grid-cols-2 md:grid-cols-2 gap-5 mt-5">
      <div>
        <h1 class="font-semibold text-xl">
          Nama Customer
        </h1>
        <h2 class="font-medium text-lg">
          {{ $customer->name }}
        </h2>
      </div>
      <div>
        <h1 class="font-semibold text-xl">
          Alamat
        </h1>
        <h2 class="font-medium text-lg">
          {{ $customer->alamat }}
        </h2>
      </div>
      <div>
        <h1 class="font-semibold text-xl">
          Layanan Wifi Terdaftar
        </h1>
        <h2 class="font-medium text-lg">
          {{ $customer->paket->name }}
        </h2>
      </div>
      <div>
        <h1 class="font-semibold text-xl">
          Pembayaran Terakhir
        </h1>
        <h2 class="font-medium text-lg">
          @if($customer->transactions->isEmpty())
          Belum Ada Pembayaran
          @else
          {{ $customer->transactions->first()->payment_month }}
          @endif
        </h2>
      </div>
      <div>
        <h1 class="font-semibold text-xl">
          Status Pembayaran Terakhir
        </h1>
        <h2 class="font-medium text-lg">
         @if($customer->transactions->isEmpty())
          Belum Ada Pembayaran
         @else
          @php
          $status = $customer->transactions->first()->status;
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
    @if($customerAlreadyPay)
    <div class="flex flex-col justify-center items-center mt-5 space-y-4">
      <h1 class="font-semibold text-2xl max-w-xl text-center">
        Anda sudah melakukan pembayaran untuk bulan ini. Jika status pembayaran belum berubah, silakan hubungi admin
      </h1>
      <a href="{{ route('transaction.pdf.download', ['record' => $detailPayment->id])}}" target="_blank" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Cetak Nota
        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
        </svg>
      </a>
    </div>
    @else
    <h1 class="text-2xl font-bold mt-5">
      Nomor Rekening Tersedia
    </h1>
    <p>
      Silakan pilih salah satu nomor rekening yang tersedia untuk melakukan pembayaran
    </p>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mt-3">
      @foreach($banks as $bank)
      <div class="bg-white h-32 rounded-lg border border-gray-300 grid grid-cols-3 justify-center items-center p-3">
        <div class="flex flex-col md:flex-row justify-center items-center">
          <img src="{{ asset('storage/' . $bank->image) }}" alt="bank logo image" class="w-20 h-20 object-contain">
        </div>
        <div class="col-span-2">
          <h1 class="font-semibold text-lg">
            {{ $bank->name }}
          </h1>
          <h2 class="font-medium text-lg">
            {{ $bank->nomor_rekening }}
          </h2>
        </div>
      </div>
      @endforeach
    </div>
    <h1 class="text-2xl font-bold mt-5">
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
        <input type="file" name="prof" class="filepond" accept="image/*" required />
      </div>
    </div>
    <div class="mt-5">
      <h1 class="font-semibold text-xl">
        Total Tagihan
      </h1>
      <h2 class="font-medium text-lg">
        Rp. 200.000
      </h2>
    </div>
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mt-5">
      Submit Pembayaran
    </button>
    @endif
  </form>
</div>
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