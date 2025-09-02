@extends('layouts.admin')
@section('title','Jadwal Pemakaian')

@section('content')
<div x-data="schedulePage()">
  {{-- Judul --}}
  <h1 class="page-pill">Jadwal Pemakaian</h1>

  {{-- Toolbar: search kiri, filter kanan --}}
  <div class="toolbar mt-6 mb-4 flex items-center justify-between gap-3">
    <form action="{{ url('/admin/schedule') }}" method="GET" class="search">
      <div class="search-wrap">
        <svg class="search-ico" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 1 0-.7.7l.3.3v.8L20 21.5 21.5 20 15.5 14Zm-6 0a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Z"/>
        </svg>
        <input type="text" name="q" placeholder="Search…" class="search-input" value="{{ request('q') }}">
      </div>
    </form>

    <div class="flex items-center gap-3">
      {{-- Filter Ruangan --}}
      <form method="GET" action="{{ url('/admin/schedule') }}" class="inline">
        <select name="room" onchange="this.form.submit()" class="chip">
          <option value="">Filter Ruangan</option>
          @php
            $rooms = $rooms ?? [
              ['id'=>1,'nama'=>'L7 - Ruang Meeting 1'],
              ['id'=>2,'nama'=>'L7 - Ruang Meeting 2'],
              ['id'=>3,'nama'=>'L7 - Ruang Meeting 3'],
            ];
          @endphp
          @foreach ($rooms as $room)
            @php $rid = is_array($room)?$room['id']:$room->id; @endphp
            <option value="{{ $rid }}" {{ (string)request('room')===(string)$rid?'selected':'' }}>
              {{ is_array($room)?$room['nama']:$room->nama }}
            </option>
          @endforeach
        </select>
      </form>

      {{-- Filter Bulan --}}
      <form method="GET" action="{{ url('/admin/schedule') }}" class="inline">
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
      <form method="GET" action="{{ url('/admin/schedule') }}" class="inline">
        <select name="year" onchange="this.form.submit()" class="chip">
          <option value="">Filter Tahun</option>
          @for ($y = now()->year; $y >= now()->year-5; $y--)
            <option value="{{ $y }}" {{ request('year')==$y?'selected':'' }}>{{ $y }}</option>
          @endfor
        </select>
      </form>
    </div>
  </div>

  {{-- Tabel --}}
  <section class="neo-card p-0 overflow-hidden">
    <div class="table-wrap">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th class="py-3 px-6">Tanggal</th>
            <th class="py-3 px-6">Nama Ruangan</th>
            <th class="py-3 px-6">Waktu Mulai</th>
            <th class="py-3 px-6">Waktu Selesai</th>
            <th class="py-3 px-6">Kebutuhan</th>
          </tr>
        </thead>
        <tbody>
          @php
            // data contoh agar tampilan langsung ada
            $schedules = $schedules ?? [[
              'date'  => '2025-07-23',
              'room'  => 'L7 - Ruang Meeting 3',
              'start' => '12.00',     // titik & tanpa detik pun aman
              'end'   => '15:00',
              'needs' => 'Kursi, Meja',
            ]];
          @endphp

          @forelse ($schedules as $S)
            @php
              $date  = is_array($S)?$S['date']:$S->tanggal;
              $room  = is_array($S)?$S['room']:$S->room->nama ?? '';
              $start = is_array($S)?$S['start']:$S->jam_mulai ?? '';
              $end   = is_array($S)?$S['end']:$S->jam_selesai ?? '';
              $needs = is_array($S)?$S['needs']:$S->kebutuhan ?? '';

              // Normalizer jam: terima 12:00:00 / 12:00 / 12.00
              $fmtTime = function ($t) {
                  if (!$t) return '';
                  $t = trim((string)$t);
                  $t = str_replace('.', ':', $t);
                  if (preg_match('/^\d{1,2}:\d{2}$/', $t)) $t .= ':00';
                  try {
                      return \Carbon\Carbon::createFromFormat('H:i:s', $t)->format('H:i');
                  } catch (\Exception $e) {
                      try { return \Carbon\Carbon::parse($t)->format('H:i'); }
                      catch (\Exception $e2) { return $t; }
                  }
              };
            @endphp
            <tr>
              <td class="py-4 px-6">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</td>
              <td class="py-4 px-6">{{ $room }}</td>
              <td class="py-4 px-6">{{ $fmtTime($start) }}</td>
              <td class="py-4 px-6">{{ $fmtTime($end) }}</td>
              <td class="py-4 px-6">{{ $needs }}</td>
            </tr>
            <tr><td colspan="5"><div class="divider mx-4"></div></td></tr>
          @empty
            <tr><td colspan="5" class="text-center py-6">Tidak ada jadwal</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>
</div>
@endsection
