@extends('components.layouts.master')

@section("content")
<section class="w-full mt-12 sm:mt-6 lg:mt-8">
  <div class="flex flex-col w-full gap-3 px-4 mx-auto my-10 sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28 lg:flex-justify lg:flex lg:flex-row">
    <div class="sm:text-center lg:text-left">
      <h1 class="max-w-3xl text-4xl font-extrabold tracking-tight text-gray-800 sm:text-5xl ">
        <span class="block xl:inline">
          Fanayu Daya Network: <span class="block text-indigo-600 xl:inline">
            Internet Cepat & Stabil</span> untuk Sragen yang Lebih
        </span>
        <span class="block text-indigo-600 xl:inline">Terkoneksi!</span>
      </h1>
      <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
        Nikmati internet tanpa batas dengan Fanayu Daya Network, pilihan tepat untuk kebutuhan internet rumah dan bisnis Anda di Sragen.
      </p>
      <!-- Button Section -->
      <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
        <div class="rounded-md shadow">
          <a href="#pricing" class="flex items-center justify-center w-full px-8 py-3 text-base font-medium text-white bg-gray-800 border border-transparent rounded-md hover:bg-gray-600 md:py-4 md:text-lg md:px-10">
            Get started
          </a>
        </div>
      </div>
      <!-- End of Button Section -->
    </div>

    <!--   Image Section     -->
    <div class="my-4 lg:inset-y-0 lg:right-0 lg:w-1/2">
      <img class="object-cover w-full h-56 sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2850&q=80" alt="">
    </div>
    <!--   End of Image Section     -->
  </div>

</section>
<x-why-choose-us />
<section class="bg-white dark:bg-gray-900" id="pricing">
  <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-24 lg:px-6">
    <div class="max-w-screen-md mx-auto mb-8 text-center lg:mb-12">
      <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
        Beragam Pilihan Paket: Pilih paket yang sesuai dengan kebutuhan aktivitas Anda.
      </h2>
      <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
        Fanayu Daya Network menyediakan paket internet yang cocok untuk semua kebutuhan, baik untuk rumah, kantor, maupun sekolah.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 md:gap-12">
      @foreach($pakets as $paket)
      <x-pricing-card title="{{ $paket->name }}" price="{{ $paket->price }}" decription="{!! $paket->information !!}" />
      @endforeach
    </div>
  </div>
</section>
@endsection