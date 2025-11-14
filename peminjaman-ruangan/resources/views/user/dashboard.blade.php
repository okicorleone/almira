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
          $firstDay = \Carbon\Carbon::create($year, $month, 1);
          $daysInMonth = $firstDay->daysInMonth;
        @endphp
        @for($i=1; $i <= $daysInMonth; $i++)
          @php
            $date = \Carbon\Carbon::create($year, $month, $i);
            $loanToday = $loans->where('tanggal', $date->toDateString());
          @endphp

          <div 
            class="cal-cell relative group cursor-pointer hover:bg-green-50 transition"
            x-data="{ show: false }" 
            @mouseenter="show = true" 
            @mouseleave="show = false"
            @click="window.location.href='{{ route('loans.create') }}?tanggal={{ $date->toDateString() }}'"
          >
            {{-- Tanggal --}}
            <span class="cal-date">{{ $i }}</span>

            {{-- Indikator ada kegiatan --}}
            @if($loanToday->count() > 0)
              <div class="mt-8 space-y-1">
                @foreach($loanToday as $loan)
                  <div class="text-xs bg-green-100 border border-green-300 rounded px-1 py-0.5 truncate">
                    <div class="font-semibold text-green-800 truncate">
                      {{ $loan->agenda }}
                    </div>
                  </div>
                @endforeach
              </div>

              {{-- POPUP DETAIL --}}
              <div 
                x-show="show"
                x-transition
                x-cloak
                class="absolute z-50 top-full left-1/2 -translate-x-1/2 mt-2 w-56 bg-white shadow-lg rounded-lg border border-gray-200 p-3 text-sm"
              >
                <div class="font-semibold text-green-700 mb-1">
                  Jadwal {{ $date->translatedFormat('d F Y') }}
                </div>
                <ul class="divide-y divide-gray-200 max-h-40 overflow-y-auto">
                  @foreach($loanToday as $loan)
                    <li class="py-1">
                      <div class="font-medium text-gray-800">
                        {{ $loan->agenda }}
                      </div>
                      <div class="text-[11px] text-gray-600">
                        {{ $loan->room->nama ?? '-' }}<br>
                        {{ \Carbon\Carbon::parse($loan->jam)->format('H:i') }} - {{ \Carbon\Carbon::parse($loan->jam_selesai)->format('H:i') }}
                      </div>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif
          </div>
        @endfor
      </div>
    </div>    

    {{-- List Jadwal --}}
    <div x-show="view==='list'" x-transition class="neo-card">
      <h2 class="card-title mb-3">Jadwal Bulan Ini (Disetujui)</h2>

      @if($loans->count() > 0)
        <div class="max-h-[400px] overflow-y-auto">
          <ul class="divide-y divide-black/10">
            @foreach($loans as $loan)
              <li class="px-4 py-3 text-sm">
                <div class="font-semibold">{{ $loan->agenda }}</div>
                <div class="opacity-80">
                  {{ $loan->room->nama ?? '-' }} — {{ \Carbon\Carbon::parse($loan->tanggal)->translatedFormat('d F Y') }}<br>
                  {{ \Carbon\Carbon::parse($loan->jam)->format('H:i') }} - {{ \Carbon\Carbon::parse($loan->jam_selesai)->format('H:i') }}
                </div>
                <div class="text-xs opacity-70 mt-1">
                  oleh {{ $loan->user->name ?? 'User' }}
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      @else
        <div class="text-center text-gray-600 py-8">
          Belum ada jadwal disetujui bulan ini.
        </div>
      @endif
    </div>

  </section>
</div>
@endsection
