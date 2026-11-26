<section class="bg-surface-container-low border-y border-surface-container-high py-16">
  <div class="max-w-7xl mx-auto px-6 lg:px-12">
    <div data-reveal class="text-center max-w-2xl mx-auto mb-12">
      <span class="text-primary-container font-bold text-xs uppercase tracking-widest">Keunggulan Layanan</span>
      <h3 class="text-2xl sm:text-3xl font-bold mt-1">Mengapa Memilih SA Properti?</h3>
    </div>
    <div data-stagger class="grid grid-cols-1 md:grid-cols-3 gap-8">
      @foreach ([
        ['fa-file-invoice-dollar', 'Transparansi RAB 100%', 'Rincian anggaran belanja terbuka tanpa biaya tersembunyi. Anda memegang kendali penuh atas spesifikasi material dan progres keuangan.'],
        ['fa-shield-halved', 'Garansi Pemeliharaan 12 Bulan', 'Jaminan garansi struktural dan kebocoran hingga 12 bulan setelah serah terima kunci.'],
        ['fa-compass-drafting', 'Bebas Konsultasi Arsitek', 'Diskusikan denah, tata ruang, dan simulasi 3D bersama tim arsitek berlisensi sebelum pengerjaan fisik dimulai.'],
      ] as [$icon, $title, $text])
        <div class="lift bg-white p-8 rounded-2xl border border-surface-container-high shadow-sm hover:shadow-md transition-shadow">
          <div class="w-12 h-12 bg-red-50 text-primary-container rounded-xl flex items-center justify-center text-xl mb-5">
            <i class="fa-solid {{ $icon }}"></i>
          </div>
          <h4 class="text-lg font-bold mb-2">{{ $title }}</h4>
          <p class="text-sm text-gray-600 leading-relaxed">{{ $text }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>