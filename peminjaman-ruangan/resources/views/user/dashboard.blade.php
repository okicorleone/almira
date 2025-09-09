@extends('layouts.app')
@section('title','Beranda')

{{-- Jika user.css sudah dimuat di layout, baris push ini boleh dihapus --}}
@push('styles')
  @vite(['resources/css/user.css'])
@endpush

@section('content')
  <div x-data="{ view: 'month' }">
    <h1 class="page-pill">Beranda</h1>

    {{-- Toolbar --}}
    <div class="toolbar mt-2">
      <div class="chip-group">
        <div class="pill-select">
          <span>Filter Ruangan</span>
          <select class="pill-select__field">
            <option>Semua</option>
          </select>
          <svg class="pill-select__caret" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
        </div>
        <div class="pill-select">
          <span>Filter Bulan</span>
          <select class="pill-select__field">
            <option>{{ now()->translatedFormat('F') }}</option>
          </select>
          <svg class="pill-select__caret" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
        </div>
      </div>

      <div class="tab-group">
        <button :class="{'tab-btn--active': view==='month'}" class="tab-btn" @click="view='month'">Bulan</button>
        <button :class="{'tab-btn--active': view==='list'}"  class="tab-btn" @click="view='list'">List</button>
      </div>
    </div>

    {{-- BOARD --}}
    <section class="board">
      <div x-show="view==='month'" class="cal neo-card p-0">
        <div class="cal-head">
          <div>Senin</div><div>Selasa</div><div>Rabu</div>
          <div>Kamis</div><div>Jum’at</div><div>Sabtu</div><div>Minggu</div>
        </div>
        <div class="cal-grid">
          @for($i=1;$i<=35;$i++)
            <div class="cal-cell">
              <span class="cal-date">{{ $i <= 31 ? $i : '' }}</span>
            </div>
          @endfor
        </div>
      </div>

      <div x-show="view==='list'" class="neo-card">
        <h2 class="card-title mb-3">Jadwal Bulan Ini</h2>
        <div class="text-center text-gray-600 py-8">Belum ada jadwal.</div>
      </div>
    </section>
  </div>
@endsection
