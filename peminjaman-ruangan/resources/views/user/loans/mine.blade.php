@extends('layouts.app')
@section('title','Pengajuan Saya')

@push('styles')
  @vite(['resources/css/user.css'])
@endpush

@section('content')
<div class="user-frame">
  <main class="content">
    <h1 class="page-pill">Pengajuan Saya</h1>

    <section class="neo-card">
      <div class="list-y">
        @forelse($loans as $l)
          <div class="list-row">
            <div>
              <div class="font-semibold">{{ $l->room->nama ?? 'Ruangan' }}</div>
              <div class="text-xs opacity-80">
                {{ \Carbon\Carbon::parse($l->start)->format('d M Y H:i') }}
                – {{ \Carbon\Carbon::parse($l->end)->format('H:i') }}
              </div>
            </div>
            <span class="chip">{{ ucfirst($l->status ?? 'pending') }}</span>
          </div>
        @empty
          <div class="text-center text-gray-600 py-8">Belum ada pengajuan.</div>
        @endforelse
      </div>
    </section>
  </main>
</div>
@endsection
