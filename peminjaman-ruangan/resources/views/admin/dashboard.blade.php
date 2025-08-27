
@extends('layouts.admin')
@section('title','Beranda')

@section('content')
<div class="admin-shell">
  {{-- SIDEBAR --}}
  <aside class="side">
    <div class="side-head">
      <svg class="h-5 w-5"><rect width="100%" height="100%" rx="2"/></svg>
      <span>Menu</span>
    </div>

    <nav class="mt-4 space-y-1">
      <a class="side-item side-item--active" href="#">
        <svg class="ico"><rect width="100%" height="100%" rx="2"/></svg>
        <span>Beranda</span>
      </a>
      <a class="side-item" href="#"><svg class="ico"></svg><span>Manajemen Ruangan</span></a>
      <a class="side-item" href="#"><svg class="ico"></svg><span>Permintaan Pinjaman</span></a>
      <a class="side-item" href="#"><svg class="ico"></svg><span>Jadwal Pemakaian</span></a>
      <a class="side-item" href="#"><svg class="ico"></svg><span>Statistik Pemakaian</span></a>
      <a class="side-item" href="#"><svg class="ico"></svg><span>Registrasi Pengguna</span></a>
    </nav>
  </aside>

  {{-- KONTEN --}}
  <section class="content">
    <h1 class="page-pill">Beranda</h1>

    <div class="grid grid-cols-12 gap-6 mt-6">
      {{-- Kolom kiri: Tabel + Grafik --}}
      <div class="col-span-12 xl:col-span-8 space-y-6">
        <div class="neo-card">
          <div class="card-title">Permintaan Peminjaman Terbaru</div>
          <div class="divider"></div>
          <div class="table-wrap">
            <table class="neo-table">
              <thead>
                <tr>
                  <th>Pemohon</th>
                  <th>Nama Ruangan</th>
                  <th>Layanan</th>
                  <th>Agenda</th>
                  <th>Jam</th>
                </tr>
              </thead>
              <tbody>
                @foreach ([
                  ['Pemohon 1','Ruangan 1','Layanan 1','Agenda 1','07.00'],
                  ['Pemohon 2','Ruangan 2','Layanan 2','Agenda 1','07.00'],
                  ['Pemohon 3','Ruangan 3','Layanan 3','Agenda 1','07.00'],
                  ['Pemohon 4','Ruangan 4','Layanan 4','Agenda 1','07.00'],
                  ['Pemohon 5','Ruangan 5','Layanan 1','Agenda 1','07.00'],
                  ['Pemohon 6','Ruangan 6','Layanan 1','Agenda 1','07.00'],
                ] as $r)
                <tr>
                  @foreach ($r as $c)<td>{{ $c }}</td>@endforeach
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="neo-card">
          <div class="card-title flex items-center justify-between">
            <span>Statistik</span>
            <div class="chip-group">
              <button class="chip">Filter Bulan</button>
              <button class="chip">Filter Tahun</button>
              <button class="chip">Filter Ruangan</button>
            </div>
          </div>
          <div class="mt-2">
            <canvas id="statChart" height="140"></canvas>
          </div>
        </div>
      </div>

      {{-- Kolom kanan: Jadwal Hari Ini --}}
      <div class="col-span-12 xl:col-span-4">
        <div class="neo-card">
          <div class="card-title">Jadwal Hari ini</div>
          <div class="divider"></div>
          <ul class="list-y">
            @foreach (range(1,8) as $i)
            <li class="list-row">
              <span>Ruangan 2</span>
              <span class="text-right">07.00</span>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    {{-- KPI --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mt-6">
      <div class="kpi-tile"><div class="kpi-value">12</div><div class="kpi-label">Peminjaman Hari Ini</div></div>
      <div class="kpi-tile"><div class="kpi-value">20</div><div class="kpi-label">Peminjaman Bulan Ini</div></div>
      <div class="kpi-tile"><div class="kpi-value">7</div><div class="kpi-label">Ruangan Tersedia</div></div>
      <div class="kpi-tile"><div class="kpi-value">5</div><div class="kpi-label">Permintaan Belum Diproses</div></div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
  {{-- Pakai CDN biar cepat; kalau mau, pindah ke Vite --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>
  <script>
    const ctx = document.getElementById('statChart');
    if (ctx) {
      const g = ctx.getContext('2d').createLinearGradient(0, 0, 0, 180);
      g.addColorStop(0, 'rgba(237,28,36,0.35)');   // merah muda atas
      g.addColorStop(1, 'rgba(237,28,36,0.00)');   // transparan
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Ruangan 1','Ruangan 2','Ruangan 3','Ruangan 4','Ruangan 5','Ruangan 6'],
          datasets: [{
            label: 'Pemakaian',
            data: [5, 22, 26, 30, 12, 50],
            fill: true,
            backgroundColor: g,
            borderColor: '#ED1C24',
            tension: .35,
            pointRadius: 3,
          }]
        },
        options: {
          plugins: { legend: { display:false } },
          scales: {
            x: { grid: { color:'rgba(0,0,0,.06)' } },
            y: { suggestedMin:0, suggestedMax:60, grid: { color:'rgba(0,0,0,.06)' } }
          }
        }
      });
    }
  </script>
@endpush
