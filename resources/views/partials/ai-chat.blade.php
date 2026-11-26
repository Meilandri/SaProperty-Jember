<div class="fixed right-4 bottom-20 md:right-6 md:bottom-6 z-[60] flex flex-col items-end gap-3">

  <div id="ai-panel" class="hidden w-[calc(100vw-2rem)] max-w-sm bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
    <div class="bg-brand-dark text-white px-4 py-3.5 flex items-center justify-between">
      <div class="flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-sm"><i class="fa-solid fa-robot"></i></div>
        <div>
          <p class="text-sm font-bold leading-tight">Asisten AI SA Properti</p>
          <p class="text-[11px] text-gray-300">Online • Siap membantu</p>
        </div>
      </div>
      <button type="button" id="ai-close" class="text-gray-300 hover:text-white" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div id="ai-messages" class="p-4 h-64 overflow-y-auto bg-gray-50 space-y-3 text-xs"></div>
    <div id="ai-quick" class="px-3 pt-3 pb-1 bg-white border-t border-gray-100 flex flex-wrap gap-2"></div>

    <form id="ai-form" class="p-3 bg-white flex items-center gap-2">
      <input id="ai-input" type="text" maxlength="500" placeholder="Tulis pertanyaan Anda..." autocomplete="off"
             class="flex-grow text-xs px-3 py-2 rounded-full border border-gray-200 focus:outline-none focus:border-primary-container">
      <button type="submit" id="ai-send" class="w-8 h-8 rounded-full bg-primary-container hover:bg-primary text-white flex items-center justify-center" aria-label="Kirim">
        <i class="fa-solid fa-paper-plane text-xs"></i>
      </button>
    </form>
  </div>

  <button type="button" id="ai-toggle"
          class="press flex items-center gap-2.5 px-5 py-3 rounded-full bg-brand-dark hover:bg-primary-container text-white font-semibold text-sm shadow-xl transition-all border border-white/10">
    <i class="fa-solid fa-wand-magic-sparkles"></i><span>Tanya AI</span>
  </button>
</div>

<script>
(function () {
  const WA = 'https://wa.me/{{ Setting::get('whatsapp') }}';
  const CHAT_URL = @json(route('chat'));
  const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;
  const GREETING = @json(Setting::get('ai_greeting'));

  const panel = document.getElementById('ai-panel');
  const box = document.getElementById('ai-messages');
  const quick = document.getElementById('ai-quick');
  const form = document.getElementById('ai-form');
  const input = document.getElementById('ai-input');
  const send = document.getElementById('ai-send');

  const faq = [
    { q: 'Layanan apa saja yang tersedia?', k: ['layanan', 'jasa', 'katalog'],
      a: 'Kami melayani renovasi, pembangunan rumah dan kos, jual beli tanah dan rumah, serta pengurusan sertifikat.' },
    { q: 'Apakah dapat desain visual?', k: ['desain', 'blueprint', 'visual', '3d'],
      a: 'Ya, setiap pesanan mendapat desain layout (blueprint) dan gambar visual hasil akhir.' },
    { q: 'Bagaimana cara konsultasi?', k: ['konsultasi', 'survei', 'survey', 'hubungi'],
      a: 'Klik tombol WhatsApp di bawah, ceritakan rencana Anda, dan tim kami akan membantu.' },
    { q: 'Berapa biaya renovasi?', k: ['biaya', 'harga', 'tarif', 'estimasi'],
      a: 'Biaya tergantung kondisi dan kebutuhan. Hubungi admin lewat WhatsApp untuk estimasi.' },
  ];

  const history = [];

  function bubble(text, who) {
    const d = document.createElement('div');
    d.className = who === 'user'
      ? 'ml-auto max-w-[85%] bg-brand-dark text-white p-3 rounded-xl rounded-tr-none whitespace-pre-line'
      : 'max-w-[85%] bg-white p-3 rounded-xl rounded-tl-none border border-gray-100 shadow-sm text-gray-700 leading-relaxed whitespace-pre-line';
    d.textContent = text; // textContent: aman dari injeksi HTML
    box.appendChild(d);
    box.scrollTop = box.scrollHeight;
    return d;
  }

  function waButton() {
    const a = document.createElement('a');
    a.href = WA; a.target = '_blank'; a.rel = 'noopener';
    a.className = 'inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-500 hover:bg-green-600 text-white font-semibold';
    a.innerHTML = '<i class="fa-brands fa-whatsapp"></i> Lanjut via WhatsApp';
    box.appendChild(a);
    box.scrollTop = box.scrollHeight;
  }

  function fallback(text) {
    const t = text.toLowerCase();
    const hit = faq.find(f => f.k.some(w => t.includes(w)));
    return hit ? hit.a : 'Terima kasih atas pertanyaannya. Untuk hal ini, tim kami bisa membantu langsung lewat WhatsApp.';
  }

  async function ask(text) {
    bubble(text, 'user');
    history.push({ role: 'user', content: text });
    send.disabled = true;
    const typing = bubble('Sedang mengetik...', 'bot');
    typing.classList.add('italic', 'text-gray-400');

    let reply;
    try {
      const res = await fetch(CHAT_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ messages: history.slice(-8) }),
      });
      const data = await res.json();
      reply = data.ok ? data.reply : fallback(text);
    } catch (e) {
      reply = fallback(text);
    }

    typing.remove();
    bubble(reply, 'bot');
    history.push({ role: 'assistant', content: reply });
    waButton();
    send.disabled = false;
  }

  faq.forEach(f => {
    const b = document.createElement('button');
    b.type = 'button';
    b.textContent = f.q;
    b.className = 'text-[11px] px-3 py-1.5 rounded-full border border-gray-200 text-gray-600 hover:border-primary-container hover:text-primary-container transition-colors';
    b.addEventListener('click', () => { if (!send.disabled) ask(f.q); });
    quick.appendChild(b);
  });

  bubble(GREETING, 'bot');

  document.getElementById('ai-toggle').addEventListener('click', () => panel.classList.toggle('hidden'));
  document.getElementById('ai-close').addEventListener('click', () => panel.classList.add('hidden'));

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const v = input.value.trim();
    if (!v || send.disabled) return;
    input.value = '';
    ask(v);
  });
})();
</script>