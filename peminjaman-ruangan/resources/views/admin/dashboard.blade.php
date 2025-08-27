@extends('layouts.admin')
@section('title', 'Beranda')

@section('content')
  {{-- Judul halaman (pill) --}}
  <h1 class="page-pill">Beranda</h1>

  {{-- Dua kolom: kiri (tabel + chart), kanan (jadwal) --}}
  <div class="grid grid-cols-12 gap-6 mt-6">
    {{-- KIRI: Tabel + Grafik --}}
    <div class="col-span-12 xl:col-span-8 space-y-6">
      {{-- Tabel Permintaan Terbaru --}}
      <section class="neo-card" aria-labelledby="tbl-permintaan-title">
        <h2 id="tbl-permintaan-title" class="card-title">Permintaan Peminjaman Terbaru</h2>
        <div class="divider"></div>

        <div class="table-wrap">
          <table class="neo-table">
            <thead>
              <tr>
                <th scope="col">Pemohon</th>
                <th scope="col">Nama Ruangan</th>
                <th scope="col">Layanan</th>
                <th scope="col">Agenda</th>
                <th scope="col">Jam</th>
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
                  @foreach ($r as $c)
                    <td>{{ $c }}</td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>

      {{-- Grafik Statistik --}}
      <section class="neo-card" aria-labelledby="statistik-title">
        <div class="card-title flex items-center justify-between">
          <h2 id="statistik-title">Statistik</h2>
          <div class="chip-group">
            <button type="button" class="chip">Filter Bulan</button>
            <button type="button" class="chip">Filter Tahun</button>
            <button type="button" class="chip">Filter Ruangan</button>
          </div>
        </div>

        {{-- ⬇️ Tambahan: wrapper tinggi tetap supaya chart proporsional --}}
        <div class="mt-2 h-[300px]">
          <canvas id="statChart" class="w-full h-full" aria-label="Grafik statistik pemakaian" role="img"></canvas>
        </div>
      </section>
    </div>

    {{-- KANAN: Jadwal Hari Ini --}}
    <aside class="col-span-12 xl:col-span-4">
      <section class="neo-card" aria-labelledby="jadwal-title">
        <h2 id="jadwal-title" class="card-title">Jadwal Hari ini</h2>
        <div class="divider"></div>

        <ul class="list-y">
          @foreach (range(1,8) as $i)
            <li class="list-row">
              <span>Ruangan 2</span>
              <span class="text-right">07.00</span>
            </li>
          @endforeach
        </ul>
      </section>
    </aside>
  </div>

  {{-- KPI Tiles --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mt-6">
    <div class="kpi-tile">
      <div class="kpi-value">12</div>
      <div class="kpi-label">Peminjaman Hari Ini</div>
    </div>
    <div class="kpi-tile">
      <div class="kpi-value">20</div>
      <div class="kpi-label">Peminjaman Bulan Ini</div>
    </div>
    <div class="kpi-tile">
      <div class="kpi-value">7</div>
      <div class="kpi-label">Ruangan Tersedia</div>
    </div>
    <div class="kpi-tile">
      <div class="kpi-value">5</div>
      <div class="kpi-label">Permintaan Belum Diproses</div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>
  <script>
    (function () {
      const el = document.getElementById('statChart');
      if (!el) return;

      const ctx = el.getContext('2d');
      const grad = ctx.createLinearGradient(0, 0, 0, 180);
      grad.addColorStop(0, 'rgba(237, 28, 36, .35)');
      grad.addColorStop(1, 'rgba(237, 28, 36, 0)');

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Ruangan 1','Ruangan 2','Ruangan 3','Ruangan 4','Ruangan 5','Ruangan 6'],
        datasets: [{
          label: 'Pemakaian',
          data: [5, 22, 26, 30, 12, 50],
          borderColor: '#ED1C24',
          backgroundColor: grad,
          tension: .35,
          pointRadius: 3,
          fill: true
        }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false, // penting agar ikut tinggi 320px di wrapper
          plugins: { legend: { display: false } },
          scales: {
            x: { grid: { color: 'rgba(0,0,0,.06)' } },
            y: {
              suggestedMin: 0,
              suggestedMax: 60,
              grid: { color: 'rgba(0,0,0,.06)' }
            }
          }
        }
      });
    })();
  </script>
@endpush
