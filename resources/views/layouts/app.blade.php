<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @auth
  <meta name="user-id" content="{{ auth()->user()->id }}">
  <meta name="is-technician" content="{{ auth()->user()->is_technician || auth()->user()->is_admin ? '1' : '0' }}">
  @endauth
  <title>{{ config('app.name', 'Laravel') }}</title>

  {{-- Tailwind CDN (opcional) --}}
  <script src="https://cdn.tailwindcss.com"></script>
  {{-- Alpine.js CDN --}}
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  {{-- OU via Vite --}}
  @vite(['resources/css/app.css'])

  <style>
    @media print {
      .no-print {
        display: none !important;
      }
    }
  </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
  <div class="min-h-screen flex flex-col">
    {{-- Navbar (escondida na impressão) --}}
    <header class="no-print bg-white shadow">
      @include('layouts.navigation')
    </header>

    {{-- Cabeçalho de página (opcional) --}}
    @isset($header)
      <div class="no-print bg-white shadow mb-4">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
          {{ $header }}
        </div>
      </div>
    @endisset

    {{-- Conteúdo principal --}}
    <main class="flex-1">
      @yield('content')
    </main>
  </div>

  {{-- Scripts --}}
  @vite(['resources/js/app.js'])
  @auth
  <script src="{{ asset('js/notifications.js') }}"></script>
  @endauth
  @stack('scripts')
</body>
</html>
