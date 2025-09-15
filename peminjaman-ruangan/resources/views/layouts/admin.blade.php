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

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

  @vite([
    'resources/css/app.css',
    'resources/css/admin.css',
    'resources/js/app.js',
    'resources/js/admin.js',
  ])

  <style>[x-cloak]{display:none!important}</style>
</head>

<body class="font-sans antialiased">
  <div class="admin-frame">
    {{-- Sidebar --}}
    <aside class="side">
      <div class="side-head">
        <button id="btnSideToggle" class="side-toggle" type="button" aria-label="Tutup/buka menu" aria-expanded="true">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <rect x="3" y="5" width="18" height="2" rx="1"></rect>
            <rect x="3" y="11" width="18" height="2" rx="1"></rect>
            <rect x="3" y="17" width="18" height="2" rx="1"></rect>
          </svg>
        </button>
        <span class="side-title">Menu</span>
      </div>

      <nav class="side-nav">
        @php $is = fn($p) => request()->is($p); @endphp

        <a href="{{ url('/admin/dashboard') }}" class="side-item {{ $is('admin/dashboard') ? 'side-item--active' : '' }}">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3 3 10h3v8h5v-5h2v5h5v-8h3z"/></svg>
          <span>Beranda</span>
        </a>

        <a href="{{ url('/admin/rooms') }}" class="side-item {{ $is('admin/rooms*') ? 'side-item--active' : '' }}">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M4 5h16v4H4zM4 11h10v8H4zM16 11h4v8h-4z"/></svg>
          <span>Manajemen Ruangan</span>
        </a>

        <a href="{{ url('/admin/loans') }}" class="side-item {{ $is('admin/loans*') ? 'side-item--active' : '' }}">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M4 6h16v2H4zM4 10h16v2H4zM4 14h10v2H4z"/></svg>
          <span>Permintaan Pinjaman</span>
        </a>

        <a href="{{ url('/admin/schedule') }}" class="side-item {{ $is('admin/schedule*') ? 'side-item--active' : '' }}">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2h2v3H7zM15 2h2v3h-2zM4 6h16v14H4zM7 10h5v5H7z"/></svg>
          <span>Jadwal Pemakaian</span>
        </a>

        <a href="{{ url('/admin/stats') }}" class="side-item {{ $is('admin/stats*') ? 'side-item--active' : '' }}">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M5 9h3v10H5zM10.5 5h3v14h-3zM16 12h3v7h-3z"/></svg>
          <span>Statistik Pemakaian</span>
        </a>

        <a href="{{ url('/admin/manageuser') }}"
           class="side-item {{ $is('admin/manageuser*') ? 'side-item--active' : '' }}">
          <svg class="ico" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4ZM4 20a8 8 0 0 1 16 0z"/></svg>
          <span>Registrasi Pengguna</span>
        </a>
      </nav>
    </aside>

    {{-- Konten + topbar kanan --}}
    <main class="content">
      {{-- === TOPBAR KANAN: Notifikasi + Profil === --}}
      <div class="topbar" x-data="{ openNotif:false, openUser:false }">
        {{-- Bell --}}
        <div class="relative">
          <button class="icon-btn" aria-label="Notifikasi" @click="openNotif=!openNotif; openUser=false">
            <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><path d="M12 22a2 2 0 0 0 2-2H10a2 2 0 0 0 2 2Zm6-6V11a6 6 0 1 0-12 0v5L4 18v1h16v-1l-2-2Z"/></svg>
            {{-- indikator notif --}}
            @if($unreadCount > 0)
              <span class="ping" aria-hidden="true"></span>
            @endif
          </button>

          {{-- panel notif --}}
          <div x-cloak x-show="openNotif" @click.outside="openNotif=false"
               x-transition.origin.top.right
               class="dropdown w-80 right-0">
            <div class="dropdown-title">Notifikasi</div>
            <ul id="notif-list" class="divide-y divide-black/10 max-h-72 overflow-auto">
            </ul>
            <div class="p-3 text-center text-sm"><a href="{{ url('/admin/loans') }}" class="underline">Lihat semua</a></div>
          </div>
        </div>

        {{-- Avatar / menu user --}}
        <div class="relative">
          <button class="avatar-btn" @click="openUser=!openUser; openNotif=false">
            <img class="avatar-img" src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User') }}" alt="avatar">
            <span class="avatar-name">{{ Auth::user()->name ?? 'Admin' }}</span>
          </button>

          <div x-cloak x-show="openUser" @click.outside="openUser=false"
               x-transition.origin.top.right
               class="dropdown right-0 w-72">
            <div class="p-4 border-b border-black/10">
              <div class="font-semibold">{{ Auth::user()->name ?? 'Admin' }}</div>
              <div class="text-xs opacity-70">{{ Auth::user()->role ?? 'Admin' }}</div>
            </div>
            <nav class="py-2">
              <a href="{{ route('profile.edit') }}" class="menu-link">
                <svg class="menu-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-8 2.5-8 5v1h16v-1c0-2.5-3-5-8-5Z"/></svg>
                Profil
              </a>
              <a href="{{ url('/admin/loans') }}" class="menu-link">
                <svg class="menu-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22a2 2 0 0 0 2-2H10a2 2 0 0 0 2 2Zm6-6V11a6 6 0 1 0-12 0v5L4 18v1h16v-1l-2-2Z"/></svg>
                Notifikasi
              </a>
              <a href="#" class="menu-link">
                <svg class="menu-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M12 8a4 4 0 1 1-4 4 4 4 0 0 1 4-4Zm8 4a8 8 0 1 1-8-8 8 8 0 0 1 8 8Z"/></svg>
                Pengaturan
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="menu-link w-full text-left">
                  <svg class="menu-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M16 17l1.41-1.41L14.83 13H21v-2h-6.17l2.58-2.59L16 7l-5 5 5 5zM4 5h7V3H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7v-2H4z"/></svg>
                  Keluar
                </button>
              </form>
            </nav>
          </div>
        </div>
      </div>
      {{-- === /TOPBAR === --}}

      @yield('content')
    </main>
  </div>

  @stack('scripts')
  <script src="//unpkg.com/alpinejs" defer></script>

  <script>
  async function fetchNotifications() {
      try {
          let res = await fetch("{{ route('admin.notifications.latest') }}");
          let data = await res.json();

          let list = document.getElementById("notif-list");
          list.innerHTML = "";

          // Permintaan terbaru
          if (data.latestRequest) {
              list.innerHTML += `
                  <li class="px-4 py-3 text-sm">
                      <div class="font-semibold">Permintaan baru</div>
                      <div class="opacity-80">${data.latestRequest.pemohon} mengajukan peminjaman ${data.latestRequest.ruangan} — ${data.latestRequest.agenda}</div>
                      <div class="text-xs opacity-70 mt-1">${data.latestRequest.waktu}</div>
                  </li>
              `;
          }

          // Jadwal terdekat
          if (data.nearestSchedule) {
              list.innerHTML += `
                  <li class="px-4 py-3 text-sm">
                      <div class="font-semibold">Jadwal segera dimulai</div>
                      <div class="opacity-80">${data.nearestSchedule.ruangan} — ${data.nearestSchedule.agenda}</div>
                      <div class="text-xs opacity-70 mt-1">${data.nearestSchedule.countdown}</div>
                  </li>
              `;
          }

          if (!data.latestRequest && !data.nearestSchedule) {
              list.innerHTML = `<li class="px-4 py-3 text-sm opacity-70">Tidak ada notifikasi</li>`;
          }

      } catch (err) {
          console.error("Gagal fetch notifikasi", err);
      }
  }

  fetchNotifications();
  setInterval(fetchNotifications, 30000); // refresh tiap 30 detik
  </script>
  <script>
  document.addEventListener("alpine:init", () => {
      Alpine.data("notifDropdown", () => ({
          openNotif: false,

          toggleNotif() {
              this.openNotif = !this.openNotif;

              if (this.openNotif) {
                  // Panggil endpoint untuk menandai sebagai read
                  fetch("/admin/notifications/read", {
                      method: "POST",
                      headers: {
                          "X-CSRF-TOKEN": "{{ csrf_token() }}",
                          "Accept": "application/json"
                      },
                  }).then(() => {
                      // Hilangkan indikator bulatan merah
                      const ping = document.querySelector(".ping");
                      if (ping) ping.remove();
                  });
              }
          }
      }))
  })
  </script>

  </body>
</html>
