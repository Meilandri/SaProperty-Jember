<footer class="bg-white border-t border-gray-200 pt-16 pb-8 text-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-gray-100">

      <div class="lg:col-span-2 space-y-4">
        <a href="{{ route('home') }}" class="inline-block">
          <img src="{{ asset('images/SaProperti.png') }}" alt="SA Properti" class="h-12 w-auto object-contain">
        </a>
        <p class="text-gray-500 text-xs sm:text-sm leading-relaxed pr-6">
            {{ Setting::get('footer_about') }}
        </p>
        <div class="text-xs text-gray-500 space-y-1">
          <p><i class="fa-solid fa-location-dot text-brand-red mr-2"></i>{{ Setting::get('address') }}</p>
          <p><i class="fa-solid fa-phone text-brand-red mr-2"></i>{{ Setting::get('phone_display') }}</p>
          <p><i class="fa-solid fa-envelope text-brand-red mr-2"></i>{{ Setting::get('email') }}</p>
        </div>
      </div>

      <div>
        <h4 class="font-bold text-sm uppercase tracking-wider mb-4">Navigasi</h4>
        <ul class="space-y-2.5 text-xs text-gray-500 font-medium">
          <li><a class="hover:text-brand-red" href="{{ route('home') }}">Beranda</a></li>
          <li><a class="hover:text-brand-red" href="{{ route('about') }}">Tentang Kami</a></li>
          <li><a class="hover:text-brand-red" href="{{ route('catalog.index') }}">Katalog</a></li>
          <li><a class="hover:text-brand-red" href="{{ route('projects.index') }}">Portofolio Proyek</a></li>
          <li><a class="hover:text-brand-red" href="{{ route('contact') }}">Kontak</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-sm uppercase tracking-wider mb-4">Layanan</h4>
        <ul class="space-y-2.5 text-xs text-gray-500 font-medium">
          @foreach (\App\Support\SiteData::catalogCategories() as $key => $name)
            <li><a class="hover:text-brand-red" href="{{ route('catalog.index', ['kategori' => $key]) }}">{{ $name }}</a></li>
          @endforeach
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-sm uppercase tracking-wider mb-4">Jam Operasional</h4>
        <p class="text-xs text-gray-500 leading-relaxed whitespace-pre-line">{{ Setting::get('hours') }}</p>
      </div>
    </div>

    <div class="pt-8 text-xs text-gray-400 text-center sm:text-left">
      {{ str_replace('{year}', date('Y'), Setting::get('copyright')) }}
    </div>
  </div>
</footer>