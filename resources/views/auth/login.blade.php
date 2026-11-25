<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex">
  <title>Login Admin - SA Properti</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-dark min-h-screen flex items-center justify-center px-4 font-sans antialiased">

  <div class="w-full max-w-sm">
    <div class="text-center mb-6 text-white">
      <p class="font-extrabold tracking-wider text-xl uppercase">SA <span class="text-primary-container">Properti</span></p>
      <p class="text-sm text-gray-400 mt-1">Masuk ke dashboard admin</p>
    </div>

    <form method="POST" action="{{ route('login.store') }}" class="bg-white rounded-3xl p-8 shadow-2xl space-y-5">
      @csrf

      <div>
        <label for="email" class="block text-sm font-semibold mb-1.5">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-primary-container text-sm">
        @error('email') <p class="mt-1 text-xs text-primary">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="password" class="block text-sm font-semibold mb-1.5">Password</label>
        <input id="password" name="password" type="password" required
               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-primary-container text-sm">
      </div>

      <label class="flex items-center gap-2 text-sm text-gray-600">
        <input type="checkbox" name="remember" class="rounded"> Ingat saya
      </label>

      <button type="submit" class="w-full py-3.5 rounded-full bg-primary-container hover:bg-primary text-white font-bold text-sm transition-colors">
        Masuk
      </button>
    </form>

    <a href="{{ route('home') }}" class="block text-center mt-5 text-sm text-gray-400 hover:text-white">
      <i class="fa-solid fa-arrow-left text-xs mr-1"></i> Kembali ke website
    </a>
  </div>

</body>
</html>