@extends('layouts.admin')
@section('title', 'Beranda')

@section('content')
  {{-- Judul --}}
  <h1 class="page-pill">Beranda</h1>

  {{-- BOARD: area tengah (scroll internal kalau panjang) --}}
  <div class="board grid grid-cols-12 gap-6">
    {{-- KIRI: dua kartu bertumpuk (tabel + chart) --}}
    <div class="col-span-12 xl:col-span-8 grid grid-rows-2 gap-6 col-stretch">
      {{-- Tabel --}}
      <section class="neo-card card-scroll" aria-labelledby="tbl-permintaan-title">
        <h2 id="tbl-permintaan-title" class="card-title">Permintaan Peminjaman Terbaru</h2>
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
                @forelse ($recentBookings as $booking)
                  <tr>
                    <td>{{ $booking->user->name ?? '-' }}</td>
                    <td>{{ $booking->room->nama ?? '-' }}</td>
                    <td>{{ $booking->user->role ?? '-' }}</td>
                    <td>{{ $booking->agenda }}</td>
                    <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->jam)->format('H:i') }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                  </tr>
                @endforelse
              </tbody>
          </table>
        </div>
      </section>

      {{-- Chart --}}
      <section class="neo-card col-stretch" aria-labelledby="statistik-title">
        <div class="card-title flex items-center justify-between">
          <h2 id="statistik-title">Statistik</h2>
          <div class="chip-group">
            <button type="button" class="chip">Filter Bulan</button>
            <button type="button" class="chip">Filter Tahun</button>
            <button type="button" class="chip">Filter Ruangan</button>
          </div>
        </div>
        <div class="mt-2 h-[320px]">
          <canvas id="statChart" class="w-full h-full" role="img" aria-label="Grafik statistik"></canvas>
        </div>
      </section>
    </div>

    {{-- KANAN: Jadwal (scroll internal) --}}
    <aside class="col-span-12 xl:col-span-4 col-stretch">
      <section class="neo-card card-scroll" aria-labelledby="jadwal-title">
        <h2 id="jadwal-title" class="card-title">Jadwal Hari ini</h2>
        <div class="divider"></div>
        <ul class="list-y">
          @foreach (range(1,12) as $i)
            <li class="list-row">
              <span>{{ $b->room->nama }}</span>
              <span class="text-right">
                  {{ \Carbon\Carbon::createFromFormat('H:i:s', $b->jam)->format('H:i') }}
              </span>
            </li>
          @empty
            <li class="list-row text-center">Tidak ada jadwal hari ini</li>
          @endforelse
        </ul>
      </section>
    </aside>
  </div>

  {{-- KPI Tiles --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mt-6">
    <div class="kpi-tile">
      <div class="kpi-value">{{ $todayCount }}</div>
      <div class="kpi-label">Peminjaman Hari Ini</div>
    </div>
    <div class="kpi-tile">
      <div class="kpi-value">{{ $monthCount }}</div>
      <div class="kpi-label">Peminjaman Bulan Ini</div>
    </div>
    <div class="kpi-tile">
      <div class="kpi-value">{{ $availableRooms }}</div>
      <div class="kpi-label">Ruangan Tersedia</div>
    </div>
    <div class="kpi-tile">
      <div class="kpi-value">{{ $pendingRequests }}</div>
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
            data: [5,22,26,30,12,50],
            borderColor: '#ED1C24',
            backgroundColor: grad,
            tension: .35,
            pointRadius: 3,
            fill: true
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,       // ikut tinggi 320px wrapper
          plugins: { legend: { display:false } },
          scales: {
            x: { grid: { color: 'rgba(0,0,0,.06)' } },
            y: { suggestedMin: 0, suggestedMax: 60, grid: { color: 'rgba(0,0,0,.06)' } }
          }
        }
      });
    })();
  </script>
@endpush
