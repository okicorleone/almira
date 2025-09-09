{{-- resources/views/layouts/user.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', config('app.name', 'Laravel'))</title>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

  {{-- PENTING: hanya user.css, jangan admin.css --}}
  @vite([
    'resources/css/app.css',
    'resources/css/user.css',
    'resources/js/app.js',
  ])

  <style>[x-cloak]{display:none!important}</style>
</head>
<body class="font-sans antialiased">
  {{-- Wrapper khusus user --}}
  <div class="user-frame">
    {{-- ===== SIDEBAR ===== --}}
    <aside class="side">
      <div class="side-head">
        <button id="btnSideToggle" class="side-toggle" type="button" aria-label="Buka/tutup menu">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <rect x="3" y="5" width="18" height="2" rx="1"></rect>
            <rect x="3" y="11" width="18" height="2" rx="1"></rect>
            <rect x="3" y="17" width="18" height="2" rx="1"></rect>
          </svg>
        </button>
        <span class="side-title">Menu</span>
      </div>

      @php $is = fn($p) => request()->is($p); @endphp
      <nav class="side-nav">
        <a href="{{ route('dashboard') }}" class="side-item {{ $is('dashboard') ? 'side-item--active' : '' }}">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3 3 10h3v8h5v-5h2v5h5v-8h3z"/></svg>
          <span>Beranda</span>
        </a>

        <a href="{{ route('loans.create') }}" class="side-item {{ $is('loans/create') ? 'side-item--active' : '' }}">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M4 6h16v2H4zM4 10h16v2H4zM4 14h10v2H4z"/></svg>
          <span>Pengajuan Pinjaman</span>
        </a>

        <a href="{{ route('loans.mine') }}" class="side-item {{ $is('loans/mine') ? 'side-item--active' : '' }}">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5ZM4 20a8 8 0 0 1 16 0z"/></svg>
          <span>Pengajuan Saya</span>
        </a>
      </nav>
    </aside>
    {{-- ===== /SIDEBAR ===== --}}

    {{-- ===== KONTEN ===== --}}
    <main class="content">
      {{-- Topbar kanan: profil + logout --}}
      <div class="topbar" x-data="{ openUser:false }">
        <div class="relative">
          <button class="avatar-btn" @click="openUser=!openUser">
            <img class="avatar-img"
                 src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User') }}"
                 alt="avatar">
            <span class="avatar-name">{{ Auth::user()->name ?? 'User' }}</span>
          </button>

          <div x-cloak x-show="openUser" @click.outside="openUser=false"
               x-transition.origin.top.right
               class="dropdown right-0 w-72" style="z-index:9999">
            <div class="p-4 border-b border-black/10">
              <div class="font-semibold">{{ Auth::user()->name ?? 'User' }}</div>
              <div class="text-xs opacity-70">Pengguna</div>
            </div>
            <nav class="py-2">
              <a href="{{ route('profile.edit') }}" class="menu-link">
                <svg class="menu-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-8 2.5-8 5v1h16v-1c0-2.5-3-5-8-5Z"/></svg>
                Profil
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="menu-link w-full text-left">
                  <svg class="menu-ico" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 17l1.41-1.41L14.83 13H21v-2h-6.17l2.58-2.59L16 7l-5 5 5 5zM4 5h7V3H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7v-2H4z"/>
                  </svg>
                  Keluar
                </button>
              </form>
            </nav>
          </div>
        </div>
      </div>

      {{-- Konten halaman specific --}}
      @yield('content')
    </main>
    {{-- ===== /KONTEN ===== --}}
  </div>

  @stack('scripts')
</body>
</html>
