<footer class="bg-white border-t border-gray-200 pt-16 pb-8 text-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-gray-100">

      <div class="lg:col-span-2 space-y-4">
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/logo.png') }}" alt="SA Properti" class="h-10 w-auto">
          <span class="font-extrabold tracking-wider text-lg uppercase">SA <span class="text-brand-red">Properti</span></span>
        </div>
        <p class="text-gray-500 text-xs sm:text-sm leading-relaxed pr-6">
          Perusahaan kontraktor arsitektur, rancang bangun baru, renovasi modern, dan konsultan investasi properti terpercaya di Indonesia.
        </p>
        <div class="text-xs text-gray-500 space-y-1">
          <p><i class="fa-solid fa-location-dot text-brand-red mr-2"></i>Grand Serpong Estate &amp; Cilandak Jakarta Selatan</p>
          <p><i class="fa-solid fa-phone text-brand-red mr-2"></i>+62 812-3456-7890</p>
          <p><i class="fa-solid fa-envelope text-brand-red mr-2"></i>info@saproperti.com</p>
        </div>
      </div>

      <div>
        <h4 class="font-bold text-sm uppercase tracking-wider mb-4">Navigasi</h4>
        <ul class="space-y-2.5 text-xs text-gray-500 font-medium">
          <li><a class="hover:text-brand-red" href="{{ route('home') }}">Beranda</a></li>
          <li><a class="hover:text-brand-red" href="{{ route('about') }}">Tentang Kami</a></li>
          <li><a class="hover:text-brand-red" href="{{ route('projects.index') }}">Portofolio Proyek</a></li>
          <li><a class="hover:text-brand-red" href="{{ route('contact') }}">Kontak</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-sm uppercase tracking-wider mb-4">Katalog Kami</h4>
        <ul class="space-y-2.5 text-xs text-gray-500 font-medium">
          <li><a class="hover:text-brand-red" href="{{ route('catalog.index') }}">Bangun Rumah Mewah</a></li>
          <li><a class="hover:text-brand-red" href="{{ route('catalog.index') }}">Renovasi &amp; Interior</a></li>
          <li><a class="hover:text-brand-red" href="{{ route('catalog.index') }}">Pembangunan Kost Komersial</a></li>
          <li><a class="hover:text-brand-red" href="{{ route('catalog.index') }}">Pengurusan IMB / PBG</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-sm uppercase tracking-wider mb-4">Jam Operasional</h4>
        <div class="text-xs text-gray-500 space-y-2 leading-relaxed">
          <p><span class="font-semibold text-gray-700">Senin - Jumat:</span><br>08.30 - 17.30 WIB</p>
          <p><span class="font-semibold text-gray-700">Sabtu:</span><br>09.00 - 15.00 WIB</p>
        </div>
      </div>
    </div>

    <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400 gap-4">
      <p>© {{ date('Y') }} SA Properti (PT SA Karya Properti Indonesia). Hak cipta dilindungi undang-undang.</p>
    </div>
  </div>
</footer>