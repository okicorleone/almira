@extends('layouts.user')
@section('title','Pengajuan Pinjaman')

@section('content')
  <h1 class="page-pill">Pengajuan Pinjaman</h1>

  {{-- Wrapper konten pakai board supaya scrollable & center --}}
  <div class="board">
    <section class="neo-card w-full max-w-xl">
      {{-- Pesan sukses --}}
      @if(session('ok'))
        <div class="chip mb-3">{{ session('ok') }}</div>
      @endif

      {{-- Form pengajuan --}}
      <form method="POST" action="{{ route('loans.store') }}" class="space-y-4">
        @csrf

        {{-- Tanggal Pinjam --}}
        <div>
          <label class="block font-semibold mb-2">Tanggal Peminjaman</label>
          <input type="date" name="tanggal" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" required>
          @error('tanggal')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        {{-- Ruangan --}}
        <div>
          <label class="block font-semibold mb-2">Nama Ruangan</label>
          <select name="room_id" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" required>
            <option value="">Pilih Ruangan</option>
            @foreach($rooms as $r)
              <option value="{{ $r->id }}">{{ $r->nama }}</option>
            @endforeach
          </select>
          @error('room_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        {{-- Agenda --}}
        <div>
          <label class="block font-semibold mb-2">Agenda</label>
          <input type="text" name="agenda" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" placeholder="Agenda kegiatan">
          @error('agenda')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        {{-- Jumlah Peserta --}}
        <div>
          <label class="block font-semibold mb-2">Jumlah Peserta</label>
          <input type="number" name="jumlah" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" placeholder="Jumlah peserta">
          @error('jumlah')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        {{-- Jam Mulai & Jam Selesai --}}
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block font-semibold mb-2">Jam Mulai</label>
            <input type="time" name="jam_mulai" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3">
            @error('jam_mulai')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
          </div>
          <div>
            <label class="block font-semibold mb-2">Jam Selesai</label>
            <input type="time" name="jam_selesai" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3">
            @error('jam_selesai')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
          </div>
        </div>

        {{-- List Kebutuhan --}}
        <div>
          <label class="block font-semibold mb-2">List Kebutuhan</label>
          <textarea name="kebutuhan" rows="3" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" placeholder="Tulis kebutuhan ruangan..."></textarea>
          @error('kebutuhan')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3 pt-4">
          <a href="{{ route('dashboard') }}" class="chip">Batal</a>
          <button type="submit" class="rounded-2xl bg-gray-700 text-white px-6 py-3 shadow-[0_6px_0_#4b5563]">Ajukan</button>
        </div>
      </form>
    </section>
  </div>
@endsection
