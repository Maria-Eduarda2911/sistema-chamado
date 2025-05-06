<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Laravel') }}</title>
  {{-- Se você quiser continuar usando o CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>
  {{-- ou via Vite --}}
  @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 font-sans antialiased">
  {{-- Navbar, wrappers, etc --}}
  <div class="min-h-screen">
    @include('layouts.navigation')

    @isset($header)
      <header class="bg-white shadow">…</header>
    @endisset

    <main>
      @yield('content')
    </main>
  </div>

  {{-- Carrega os JS: Vite + stack de scripts --}}
  @vite(['resources/js/app.js'])
  @stack('scripts')
</body>
</html>
