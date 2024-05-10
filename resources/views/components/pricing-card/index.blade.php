@props(['title', 'price', 'decription'])
<div class="flex flex-col p-6 mx-auto space-y-4 text-center text-gray-900 bg-white border border-gray-100 rounded-lg shadow g dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
  <h3 class="text-2xl font-semibold">
    {{ $title }}
  </h3>
  <div class="flex flex-col items-center justify-center">
    <span class="text-5xl font-extrabold">
      Rp. {{ number_format(floatval($price), 0,0) }}
    </span>
    <span class="text-gray-500 dark:text-gray-400">/bulan</span>
  </div>

  <div class="mb-4 text-start no-tailwindcss-base">
    {!! $decription !!}
  </div>

  <a href="#" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-indigo-900">Get
    started</a>
</div>