{{-- resources/views/user/dashboard.blade.php --}}
@extends('layouts.user')
@section('title','Beranda')

@section('content')
<div x-data="{ view: 'month' }">
  {{-- Judul --}}
  <h1 class="page-pill">Beranda</h1>

  {{-- ===== Toolbar ===== --}}
  <div class="toolbar mt-4 mb-6">
    {{-- Filter Ruangan --}}
    <div class="pill-select">
      <span>Filter Ruangan</span>
      <select class="pill-select__field" onchange="window.location='?room_id='+this.value">
        <option value="">Semua</option>
        @foreach($rooms as $room)
          <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
            {{ $room->nama }}
          </option>
        @endforeach
      </select>
      <svg class="pill-select__caret" viewBox="0 0 24 24" fill="currentColor">
        <path d="M7 10l5 5 5-5z"/>
      </svg>
    </div>
    {{-- Filter Bulan --}}
    <div class="pill-select">
      <span>Filter Bulan</span>
      <select class="pill-select__field" onchange="window.location='?month='+this.value+'&year={{ $year }}'">
        @for($m=1;$m<=12;$m++)
          <option value="{{ $m }}" {{ $m==$month ? 'selected':'' }}>
            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
          </option>
        @endfor
      </select>
      <svg class="pill-select__caret" viewBox="0 0 24 24" fill="currentColor">
        <path d="M7 10l5 5 5-5z"/>
      </svg>
    </div>

    {{-- Tab switch: Bulan / List --}}
    <div class="tab-group">
      <button 
        :class="{'tab-btn--active': view==='month'}" 
        class="tab-btn" 
        @click="view='month'">
        Bulan
      </button>
      <button 
        :class="{'tab-btn--active': view==='list'}"  
        class="tab-btn" 
        @click="view='list'">
        List
      </button>
    </div>
  </div>

  {{-- ===== BOARD ===== --}}
  <section class="board">
    {{-- Kalender Bulan --}}
    <div x-show="view==='month'" x-transition class="cal neo-card p-0">
      <div class="cal-head">
        <div>Senin</div>
        <div>Selasa</div>
        <div>Rabu</div>
        <div>Kamis</div>
        <div>Jum’at</div>
        <div>Sabtu</div>
        <div>Minggu</div>
      </div>
      <div class="cal-grid">
        @php
          // ambil tanggal awal bulan sesuai filter
          $firstDay = \Carbon\Carbon::create($year, $month, 1);
          $daysInMonth = $firstDay->daysInMonth;
        @endphp

        @for($i=1; $i <= $daysInMonth; $i++)
          @php
            $date = \Carbon\Carbon::create($year, $month, $i);
            $loanToday = $loans->where('tanggal', $date->toDateString());
          @endphp
          <div class="cal-cell">
            <span class="cal-date">{{ $i }}</span>
            @if($loanToday->count() > 0)
              <div class="mt-1 text-xs text-red-600">
                {{ $loanToday->count() }} Jadwal
              </div>
            @endif
          </div>
        @endfor
      </div>
    </div>    

    {{-- List Jadwal --}}
<div x-show="view==='list'" x-transition class="neo-card">
  <h2 class="card-title mb-3">Jadwal Bulan Ini</h2>

  @if($loans->count() > 0)
    <div class="max-h-[400px] overflow-y-auto">
      <ul class="divide-y divide-black/10">
        @foreach($loans as $loan)
          <li class="px-4 py-3 text-sm">
            <div class="font-semibold">{{ $loan->agenda }}</div>
            <div class="opacity-80">{{ $loan->room->name }} — {{ $loan->date }}</div>
            <div class="text-xs opacity-70 mt-1">oleh {{ $loan->user->name ?? 'User' }}</div>
          </li>
        @endforeach
      </ul>
    </div>
  @else
    <div class="text-center text-gray-600 py-8">Belum ada jadwal.</div>
  @endif
</div>

  </section>
</div>
@endsection
