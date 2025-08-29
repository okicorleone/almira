<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>
    @hasSection('title')
      @yield('title') — {{ config('app.name', 'Laravel') }}
    @else
      {{ config('app.name', 'Laravel') }}
    @endif
  </title>

  {{-- Fonts (opsional) --}}
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

  {{-- Styles & Scripts --}}
  {{-- pastikan admin.css & admin.js ikut di-bundle --}}
  @vite([
    'resources/css/app.css',
    'resources/css/admin.css',
    'resources/js/app.js',
    'resources/js/admin.js',
  ])
</head>

<body class="font-sans antialiased">
  {{-- ===== FRAME: sidebar + content (konten yang scroll) ===== --}}
  <div class="admin-frame">
    {{-- Sidebar --}}
    <aside class="side">
      <div class="side-head">
        <button id="btnSideToggle" class="side-toggle" type="button"
                aria-label="Tutup/buka menu" aria-expanded="true">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <rect x="3" y="5"  width="18" height="2" rx="1"></rect>
            <rect x="3" y="11" width="18" height="2" rx="1"></rect>
            <rect x="3" y="17" width="18" height="2" rx="1"></rect>
          </svg>
        </button>
        <span class="side-title">Menu</span>
      </div>

      <nav class="side-nav">
        @php $is = fn($p) => request()->is($p); @endphp

        <a href="{{ url('/admin') }}"
           class="side-item {{ $is('admin') ? 'side-item--active' : '' }}"
           title="Beranda">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3 3 10h3v8h5v-5h2v5h5v-8h3z"/></svg>
          <span>Beranda</span>
        </a>

        <a href="{{ url('/admin/rooms') }}"
           class="side-item {{ $is('admin/rooms*') ? 'side-item--active' : '' }}"
           title="Manajemen Ruangan">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M4 5h16v4H4zM4 11h10v8H4zM16 11h4v8h-4z"/></svg>
          <span>Manajemen Ruangan</span>
        </a>

        <a href="{{ url('/admin/loans') }}"
           class="side-item {{ $is('admin/loans*') ? 'side-item--active' : '' }}"
           title="Permintaan Pinjaman">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M4 6h16v2H4zM4 10h16v2H4zM4 14h10v2H4z"/></svg>
          <span>Permintaan Pinjaman</span>
        </a>

        <a href="{{ url('/admin/schedule') }}"
           class="side-item {{ $is('admin/schedule*') ? 'side-item--active' : '' }}"
           title="Jadwal Pemakaian">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2h2v3H7zM15 2h2v3h-2zM4 6h16v14H4zM7 10h5v5H7z"/></svg>
          <span>Jadwal Pemakaian</span>
        </a>

        <a href="{{ url('/admin/stats') }}"
           class="side-item {{ $is('admin/stats*') ? 'side-item--active' : '' }}"
           title="Statistik Pemakaian">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M5 9h3v10H5zM10.5 5h3v14h-3zM16 12h3v7h-3z"/></svg>
          <span>Statistik Pemakaian</span>
        </a>

        <a href="{{ url('/admin/users') }}"
           class="side-item {{ $is('admin/users*') ? 'side-item--active' : '' }}"
           title="Registrasi Pengguna">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4ZM4 20a8 8 0 0 1 16 0z"/></svg>
          <span>Registrasi Pengguna</span>
        </a>
      </nav>
    </aside>

    {{-- Konten (yang boleh scroll) --}}
    <main class="content">
      @yield('content')
    </main>
  </div>

  {{-- Script khusus halaman (Chart.js, dll) --}}
  @stack('scripts')
</body>
</html>
