@php

$company = app\models\Company::first();

@endphp

<div class="bg-gray-100">
  <div class="px-4 pt-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
    <div class="grid gap-10 row-gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
      <div class="col-span-2">
        <a href="/" target="_blank" aria-label="Go home" title="Company" class="inline-flex flex-col items-center w-full md:flex-row">
          <image src="{{ asset('storage') . '/' . $company->logo }}" alt="Company Logo" class="object-contain w-16 h-16" />
          <span class="ml-2 text-xl font-bold tracking-wide text-gray-800 uppercase">
            {{ $company->name }}
          </span>
        </a>
        <div class="mt-6 lg:max-w-sm">
          <p class="text-sm text-gray-800">
            Nikmati internet cepat dan stabil untuk streaming film, bermain game online, belajar online, dan semua aktivitas internet Anda lainnya. Dapatkan juga layanan pelanggan yang ramah dan profesional dari tim kami yang siap membantu Anda anytime, anywhere
          </p>
        </div>
      </div>
      <div class="col-span-2 space-y-2 text-sm md:col-span-1">
        <p class="text-base font-bold tracking-wide text-gray-900">Contacts</p>
        <div class="flex">
          <p class="mr-1 text-gray-800">Telepon:</p>
          <a href="tel:{{ $company->no_telp }}" aria-label="Our phone" title="Our phone" class="transition-colors duration-300 text-deep-purple-accent-400 hover:text-deep-purple-800">
            {{ $company->no_telp }}
          </a>
        </div>
        <div class="flex">
          <p class="mr-1 text-gray-800">Email:</p>
          <a href="mailto:info@lorem.mail" aria-label="Our email" title="Our email" class="transition-colors duration-300 text-deep-purple-accent-400 hover:text-deep-purple-800">
            {{ $company->email }}
          </a>
        </div>
        <div class="flex">
          <p class="mr-1 text-gray-800">Alamat:</p>
          <a href="https://maps.app.goo.gl/URJWawQhRtu4rbYN7" target="_blank" rel="noopener noreferrer" aria-label="Our address" title="Our address" class="transition-colors duration-300 text-deep-purple-accent-400 hover:text-deep-purple-800">
            {{ $company->alamat }}
          </a>
        </div>
      </div>
      <div class="">
        <span class="text-base font-bold tracking-wide text-gray-900">Social</span>
        <div class="flex items-center mt-1 space-x-3">
          <a href="/" target="_blank" class="text-gray-500 transition-colors duration-300 hover:text-deep-purple-accent-400">
            <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
              <path d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6 c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1 C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4 c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6 C22.5,6.4,23.3,5.5,24,4.6z"></path>
            </svg>
          </a>
          <a href="/" target="_blank" class="text-gray-500 transition-colors duration-300 hover:text-deep-purple-accent-400">
            <svg viewBox="0 0 30 30" fill="currentColor" class="h-6">
              <circle cx="15" cy="15" r="4"></circle>
              <path d="M19.999,3h-10C6.14,3,3,6.141,3,10.001v10C3,23.86,6.141,27,10.001,27h10C23.86,27,27,23.859,27,19.999v-10   C27,6.14,23.859,3,19.999,3z M15,21c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S18.309,21,15,21z M22,9c-0.552,0-1-0.448-1-1   c0-0.552,0.448-1,1-1s1,0.448,1,1C23,8.552,22.552,9,22,9z"></path>
            </svg>
          </a>
          <a href="/" target="_blank" class="text-gray-500 transition-colors duration-300 hover:text-deep-purple-accent-400">
            <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
              <path d="M22,0H2C0.895,0,0,0.895,0,2v20c0,1.105,0.895,2,2,2h11v-9h-3v-4h3V8.413c0-3.1,1.893-4.788,4.659-4.788 c1.325,0,2.463,0.099,2.795,0.143v3.24l-1.918,0.001c-1.504,0-1.795,0.715-1.795,1.763V11h4.44l-1,4h-3.44v9H22c1.105,0,2-0.895,2-2 V2C24,0.895,23.105,0,22,0z"></path>
            </svg>
          </a>
        </div>
      </div>
      <div class="col-span-2"></div>
      <div class="col-span-2">
        <div class="maps">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.003773686955!2d110.93067479829257!3d-7.464832385640936!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a1baac47b54ad%3A0x4530c48aea84cbd9!2sMasjid%20Al%20Daud!5e0!3m2!1sid!2sid!4v1720449053539!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
    <div class="flex flex-col-reverse justify-between pt-5 pb-10 border-t lg:flex-row">
      <p class="text-sm text-gray-600">
        © Copyright 2020 Lorem Inc. All rights reserved.
      </p>
      <ul class="flex flex-col mb-3 space-y-2 lg:mb-0 sm:space-y-0 sm:space-x-5 sm:flex-row">
        <li>
          <a href="/" target="_blank" class="text-sm text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400">F.A.Q</a>
        </li>
        <li>
          <a href="/" target="_blank" class="text-sm text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400">Privacy Policy</a>
        </li>
        <li>
          <a href="/" target="_blank" class="text-sm text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400">Terms &amp; Conditions</a>
        </li>
      </ul>
    </div>
  </div>
</div>