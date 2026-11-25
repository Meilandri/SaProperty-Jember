<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
  <div class="relative bg-brand-dark text-white rounded-3xl p-8 sm:p-12 lg:p-16 overflow-hidden shadow-xl">
    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-primary-container/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative z-10 max-w-3xl">
      <h3 class="text-2xl sm:text-4xl font-extrabold tracking-tight leading-tight">
        {{ $title ?? 'Punya Rencana Bangun Rumah atau Properti Komersial?' }}
      </h3>
      <p class="mt-4 text-gray-300 text-sm sm:text-base leading-relaxed">
        {{ $text ?? 'Hubungi konsultan SA Properti untuk survey lokasi, perhitungan estimasi anggaran kasar, dan paparan portofolio lengkap tanpa dipungut biaya.' }}
      </p>
      <div class="mt-8">
        <a href="https://wa.me/{{ Setting::get('whatsapp') }}" target="_blank"
           class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-primary-container hover:bg-primary text-white font-bold text-sm transition">
          <i class="fa-brands fa-whatsapp text-lg"></i> Konsultasi Lewat WhatsApp
        </a>
      </div>
    </div>
  </div>
</section>