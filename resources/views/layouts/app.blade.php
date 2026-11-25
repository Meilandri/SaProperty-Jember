<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'SA Properti - Jasa Rancang Bangun, Renovasi & Investasi Properti')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface text-brand-dark antialiased font-sans selection:bg-brand-red selection:text-white">

  @include('partials.site-header')

  <main class="pt-14 md:pt-28">
    @yield('content')
  </main>

  {{-- pb-16 di mobile supaya footer tidak tertutup navigasi bawah --}}
  <div class="pb-16 md:pb-0 bg-white">
    @include('partials.footer')
  </div>

  @include('partials.bottom-nav')
  @include('partials.ai-chat')

  @stack('scripts')
</body>
</html>