@extends('layouts.admin')
@section('title','Jadwal Pemakaian')

@section('content')
<div x-data="schedulePage()">
  {{-- Judul --}}
  <h1 class="page-pill">Jadwal Pemakaian</h1>

  {{-- Toolbar: search kiri, filter kanan --}}
  <div class="toolbar mt-6 mb-4 flex items-center justify-between gap-3">
    {{-- Pakai komponen search --}}
    <x-search route="{{ url('/admin/schedule') }}" />

    <div class="flex items-center gap-3">
      {{-- Filter Ruangan --}}
      <form method="GET" action="{{ url('/admin/schedule') }}" class="inline">
        <select name="room" onchange="this.form.submit()" class="chip">
          <option value="">Filter Ruangan</option>
          @foreach ($rooms ?? [] as $room)
            <option value="{{ $room->id }}" {{ request('room')==$room->id?'selected':'' }}>
              {{ $room->nama }}
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

  {{-- ==== TABEL ==== --}}
  <section class="neo-card p-0 overflow-hidden">
    <div class="table-wrap">
      <div class="max-h-[500px] overflow-y-auto">
        <table class="neo-table w-full">
          <thead>
            <tr>
              <th class="py-3 px-6">Tanggal Peminjaman</th>
              <th class="py-3 px-6">Nama Ruangan</th>
              <th class="py-3 px-6">Pemohon</th>
              <th class="py-3 px-6">Agenda</th>
              <th class="py-3 px-6">Jumlah Peserta</th>
              <th class="py-3 px-6">Waktu Mulai</th>
              <th class="py-3 px-6">Waktu Selesai</th>
              <th class="py-3 px-6">Kebutuhan</th>
              <th class="py-3 px-6">Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($schedules as $S)
              <tr>
                <td class="py-4 px-6">{{ \Carbon\Carbon::parse($S->tanggal)->translatedFormat('d M Y') }}</td>
                <td class="py-4 px-6">{{ $S->room->nama ?? '-' }}</td>
                <td class="py-4 px-6">{{ $S->user->name ?? '-' }}</td>
                <td class="py-4 px-6">{{ $S->agenda ?? '-' }}</td>
                <td class="py-4 px-6 text-center">{{ $S->jumlah_peserta ?? '-' }}</td>
                <td class="py-4 px-6">{{ $S->jam_mulai ? \Carbon\Carbon::parse($S->jam_mulai)->format('H:i') : '-' }}</td>
                <td class="py-4 px-6">{{ $S->jam_selesai ? \Carbon\Carbon::parse($S->jam_selesai)->format('H:i') : '-' }}</td>
                <td class="py-4 px-6">{{ $S->list_kebutuhan ?? '-' }}</td>
                <td class="py-4 px-6">
                  @if($S->status == 'approved')
                    <span class="text-green-600 font-semibold">Diterima</span>
                  @elseif($S->status == 'rejected')
                    <span class="text-red-600 font-semibold">Ditolak</span>
                  @else
                    <span class="text-gray-600 font-semibold">Menunggu</span>
                  @endif
                </td>
              </tr>
              <tr><td colspan="9"><div class="divider mx-4"></div></td></tr>
            @empty
              <tr><td colspan="9" class="text-center py-6">Tidak ada jadwal</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </section>
  
    {{-- Tombol Export Excel (sementara dummy) --}}
  <div class="mt-6 flex justify-center">
    <a href="#"
       class="rounded-2xl bg-emerald-600 text-white px-8 py-3 text-xl
              shadow-[0_6px_0_#059669] hover:bg-emerald-700 transition">
      Export ke Excel
    </a>
  </div>

</div>
@endsection
