@extends('layouts.admin')
@section('title','Statistik Pemakaian')

@section('content')
<div>
  {{-- Judul --}}
  <h1 class="page-pill">Statistik Pemakaian</h1>

  {{-- Toolbar: filter --}}
  <div class="toolbar mt-6 mb-4 flex items-center gap-3">
    <span class="font-semibold mr-2">Sort By :</span>

    {{-- Filter Tanggal --}}
    <form method="GET" action="{{ url('/admin/stats') }}" class="inline">
      <select name="day" onchange="this.form.submit()" class="chip">
        <option value="">Filter Tanggal</option>
        @for ($d=1; $d<=31; $d++)
          <option value="{{ $d }}" {{ request('day')==$d?'selected':'' }}>{{ $d }}</option>
        @endfor
      </select>
    </form>

    {{-- Filter Bulan --}}
    <form method="GET" action="{{ url('/admin/stats') }}" class="inline">
      <select name="month" onchange="this.form.submit()" class="chip">
        <option value="">Filter Bulan</option>
        @for ($m=1; $m<=12; $m++)
          <option value="{{ $m }}" {{ request('month')==$m?'selected':'' }}>
            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
          </option>
        @endfor
      </select>
    </form>

    {{-- Filter Tahun --}}
    <form method="GET" action="{{ url('/admin/stats') }}" class="inline">
      <select name="year" onchange="this.form.submit()" class="chip">
        <option value="">Filter Tahun</option>
        @for ($y = now()->year; $y >= now()->year-5; $y--)
          <option value="{{ $y }}" {{ request('year')==$y?'selected':'' }}>{{ $y }}</option>
        @endfor
      </select>
    </form>
  </div>

  {{-- Chart --}}
  <section class="neo-card col-stretch" aria-labelledby="statistik-title">
    <div class="card-title">Statistik</div>
    <div class="mt-2 h-[320px]">
      <canvas id="statChart" class="w-full h-full" role="img" aria-label="Grafik statistik"></canvas>
    </div>
  </section>
</div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>
  @php
    // fallback data kalau controller tidak kirim
    $chartLabels = $labels ?? ['Ruangan 1','Ruangan 2','Ruangan 3','Ruangan 4','Ruangan 5','Ruangan 6'];
    $chartData   = $data ?? [4,24,29,22,13,50];
  @endphp
  <script>
    (function () {
      const el = document.getElementById('statChart');
      if (!el) return;
      const ctx = el.getContext('2d');

      const grad = ctx.createLinearGradient(0, 0, 0, 250);
      grad.addColorStop(0, 'rgba(237, 28, 36, 0.35)');
      grad.addColorStop(1, 'rgba(237, 28, 36, 0)');

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: @json($chartLabels),
          datasets: [{
            label: 'Total Pemakaian',
            data: @json($chartData),
            borderColor: '#8B5CF6',
            backgroundColor: grad,
            pointBorderColor: '#ED1C24',
            pointBackgroundColor: '#ED1C24',
            pointRadius: 3,
            tension: .35,
            fill: true
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display:false } },
          scales: {
            x: { grid: { color: 'rgba(0,0,0,.06)' } },
            y: { grid: { color: 'rgba(0,0,0,.06)' } }
          }
        }
      });
    })();
  </script>
@endpush
