@extends('layouts.user')
@section('title','Pengajuan Pinjaman')

@section('content')
  <h1 class="page-pill">Pengajuan Pinjaman</h1>

  {{-- Wrapper konten pakai board supaya scrollable & full --}}
  <div class="board">
    <section class="neo-card w-full">
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
          <input 
            type="date" 
            name="tanggal" 
            value="{{ old('tanggal') }}" 
            class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" 
            required
          >
          @error('tanggal')
            <div class="text-red-600 text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Ruangan --}}
        <div>
          <label class="block font-semibold mb-2">Nama Ruangan</label>
          <select name="room_id" class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" required>
            <option value="">Pilih Ruangan</option>
            @foreach($rooms as $r)
              <option value="{{ $r->id }}" {{ old('room_id') == $r->id ? 'selected' : '' }}>
                {{ $r->nama }}
              </option>
            @endforeach
          </select>
          @error('room_id')
            <div class="text-red-600 text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Agenda --}}
        <div>
          <label class="block font-semibold mb-2">Agenda</label>
          <input 
            type="text" 
            name="agenda" 
            value="{{ old('agenda') }}" 
            class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" 
            placeholder="Agenda kegiatan" 
            required
          >
          @error('agenda')
            <div class="text-red-600 text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Jumlah Peserta --}}
        <div>
          <label class="block font-semibold mb-2">Jumlah Peserta</label>
          <input 
            type="number" 
            name="jumlah_peserta" 
            value="{{ old('jumlah_peserta') }}" 
            class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" 
            placeholder="Jumlah peserta" 
            required
          >
          @error('jumlah_peserta')
            <div class="text-red-600 text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Jam Mulai & Jam Selesai --}}
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block font-semibold mb-2">Jam Mulai</label>
            <input 
              type="time" 
              name="jam" 
              value="{{ old('jam') }}" 
              class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" 
              required
            >
            @error('jam')
              <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
          </div>
          <div>
            <label class="block font-semibold mb-2">Jam Selesai</label>
            <input 
              type="time" 
              name="jam_selesai" 
              value="{{ old('jam_selesai') }}" 
              class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" 
              required
            >
            @error('jam_selesai')
              <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
          </div>
        </div>

        {{-- list_kebutuhan --}}
        <div>
          <label class="block font-semibold mb-2">List Kebutuhan</label>
          <textarea 
            name="list_kebutuhan" 
            rows="3" 
            class="w-full rounded-2xl bg-neutral-300/80 px-4 py-3" 
            placeholder="Tulis list kebutuhan ruangan..."
          >{{ old('list_kebutuhan') }}</textarea>
          @error('list_kebutuhan')
            <div class="text-red-600 text-sm">{{ $message }}</div>
          @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3 pt-4">
          <button type="submit" class="rounded-2xl bg-gray-700 text-white px-6 py-3 shadow-[0_6px_0_#4b5563]">
            Ajukan
          </button>
        </div>
      </form>
    </section>
  </div>
@endsection
