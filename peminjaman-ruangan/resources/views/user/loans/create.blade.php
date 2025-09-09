@extends('layouts.app')
@section('title','Pengajuan Pinjaman')

@push('styles')
  @vite(['resources/css/user.css'])
@endpush

@section('content')
<div class="user-frame">
  <main class="content">
    <h1 class="page-pill">Ajukan Pinjaman</h1>

    <section class="neo-card max-w-xl">
      @if(session('ok')) <div class="chip mb-3">{{ session('ok') }}</div> @endif

      <form method="POST" action="{{ route('loans.store') }}" class="space-y-4">
        @csrf
        <div>
          <label class="font-semibold">Ruangan</label>
          <select name="room_id" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3">
            @foreach($rooms as $r)
              <option value="{{ $r->id }}">{{ $r->nama }}</option>
            @endforeach
          </select>
          @error('room_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="font-semibold">Mulai</label>
            <input type="datetime-local" name="start" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3">
            @error('start')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
          </div>
          <div>
            <label class="font-semibold">Selesai</label>
            <input type="datetime-local" name="end" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3">
            @error('end')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
          </div>
        </div>

        <div>
          <label class="font-semibold">Catatan</label>
          <textarea name="note" rows="3" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3"></textarea>
        </div>

        <div class="flex justify-end gap-3">
          <a href="{{ route('dashboard') }}" class="chip">Batal</a>
          <button class="rounded-2xl bg-gray-700 text-white px-6 py-3 shadow-[0_6px_0_#4b5563]">Kirim</button>
        </div>
      </form>
    </section>
  </main>
</div>
@endsection
