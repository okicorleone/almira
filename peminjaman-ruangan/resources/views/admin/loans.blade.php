@extends('layouts.admin')
@section('title','Permintaan Peminjaman')

@section('content')
<div x-data="loansPage()">
  {{-- Judul --}}
  <h1 class="page-pill">Permintaan Peminjaman</h1>

  {{-- ==== Toolbar (copy persis dari rooms): Search kiri + Tombol/Filter kanan ==== --}}
  <div class="toolbar mt-6 mb-4 flex items-center justify-between gap-3">
    <form action="{{ url('/admin/loans') }}" method="GET" class="search">
      <div class="search-wrap">
        {{-- KACA PEMBESAR KECIL (20px) --}}
        <svg class="search-ico" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 1 0-.7.7l.3.3v.8L20 21.5 21.5 20 15.5 14Zm-6 0a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Z"/>
        </svg>
        <input type="text" name="q" placeholder="Cari…" class="search-input" value="{{ request('q') }}">
      </div>
    </form>

    {{-- Filter chips di kanan --}}
    <div class="flex items-center gap-3">
      <form method="GET" action="{{ url('/admin/loans') }}" class="inline">
        <select name="room" onchange="this.form.submit()" class="chip">
          <option value="">Filter Ruangan</option>
          @php
            $rooms = $rooms ?? [
              ['id'=>1,'nama'=>'L7 - RUANG MEETING 1'],
              ['id'=>2,'nama'=>'L7 - RUANG MEETING 2'],
              ['id'=>3,'nama'=>'L7 - RUANG MEETING 3'],
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

      <form method="GET" action="{{ url('/admin/loans') }}" class="inline">
        <select name="month" onchange="this.form.submit()" class="chip">
          <option value="">Filter Bulan</option>
          @for ($m=1; $m<=12; $m++)
            <option value="{{ $m }}" {{ request('month')==$m?'selected':'' }}>
              {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
            </option>
          @endfor
        </select>
      </form>

      <form method="GET" action="{{ url('/admin/loans') }}" class="inline">
        <select name="year" onchange="this.form.submit()" class="chip">
          <option value="">Filter Tahun</option>
          @for ($y=now()->year; $y>=now()->year-5; $y--)
            <option value="{{ $y }}" {{ request('year')==$y?'selected':'' }}>{{ $y }}</option>
          @endfor
        </select>
      </form>
    </div>
  </div>

  {{-- ==== TABEL ==== --}}
  <section class="neo-card p-0">
    <div class="table-wrap overflow-x-auto">
      <table class="neo-table min-w-full">
        <thead>
          <tr>
            <th class="py-3 px-6">Tanggal Booking</th>
            <th class="py-3 px-6">Tanggal Peminjaman</th>
            <th class="py-3 px-6">Nama Ruangan</th>
            <th class="py-3 px-6">Pemohon</th>
            <th class="py-3 px-6">Departemen/Layanan</th>
            <th class="py-3 px-6">Agenda</th>
            <th class="py-3 px-6 text-center">Jumlah Peserta</th>
            <th class="py-3 px-6">Waktu Mulai</th>
            <th class="py-3 px-6">Waktu Selesai</th>
            <th class="py-3 px-6">List Kebutuhan</th>
            <th class="py-3 px-6">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php
            // dummy agar tampilan langsung terlihat
            $loans = $loans ?? [[
              'id'=>101,
              'booked_at'=>'2025-07-11 14:00:45',
              'date'=>'2025-07-17',
              'room'=>'L7 - RUANG MEETING 3',
              'user'=>'Annisa Fernanda',
              'dept'=>'Ecare Telkomsel',
              'agenda'=>'Meeting Improvement',
              'count'=>10,
              'start'=>'09:00:00',
              'end'=>'12:00:00',
              'needs'=>'TV + Kursi',
            ]];
          @endphp

          @forelse ($loans as $L)
            @php
              $id      = is_array($L)?$L['id']:$L->id;
              $booked  = is_array($L)?$L['booked_at']:$L->booked_at;
              $date    = is_array($L)?$L['date']:$L->date;
              $room    = is_array($L)?$L['room']:$L->room->nama;
              $user    = is_array($L)?$L['user']:$L->user->name;
              $dept    = is_array($L)?$L['dept']:$L->department;
              $agenda  = is_array($L)?$L['agenda']:$L->agenda;
              $count   = is_array($L)?$L['count']:$L->jumlah_peserta;
              $start   = is_array($L)?$L['start']:$L->jam_mulai;
              $end     = is_array($L)?$L['end']:$L->jam_selesai;
              $needs   = is_array($L)?$L['needs']:$L->kebutuhan;
            @endphp
            <tr>
              <td class="py-4 px-6">{{ \Carbon\Carbon::parse($booked)->translatedFormat('d M Y, H:i:s') }}</td>
              <td class="py-4 px-6">{{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}</td>
              <td class="py-4 px-6">{{ $room }}</td>
              <td class="py-4 px-6">{{ $user }}</td>
              <td class="py-4 px-6">{{ $dept }}</td>
              <td class="py-4 px-6">{{ $agenda }}</td>
              <td class="py-4 px-6 text-center">{{ $count }}</td>
              <td class="py-4 px-6">{{ \Carbon\Carbon::createFromFormat('H:i:s',$start)->format('H:i') }}</td>
              <td class="py-4 px-6">{{ \Carbon\Carbon::createFromFormat('H:i:s',$end)->format('H:i') }}</td>
              <td class="py-4 px-6">{{ $needs }}</td>
              <td class="py-4 px-6">
                <div class="flex items-center gap-4">
                  <a href="#" class="text-green-600 font-semibold"
                     @click.prevent="openApprove({id:{{ $id }}, user:'{{ $user }}', room:'{{ str_replace("'","\\'",$room) }}'})">Terima</a>
                  <a href="#" class="text-red-600 font-semibold"
                     @click.prevent="openReject({id:{{ $id }}, user:'{{ $user }}', room:'{{ str_replace("'","\\'",$room) }}'})">Tolak</a>
                </div>
              </td>
            </tr>
            <tr><td colspan="11"><div class="divider mx-4"></div></td></tr>
          @empty
            <tr><td colspan="11" class="text-center py-6">Tidak ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

  {{-- ==== MODAL TERIMA ==== --}}
  <x-neo-modal show="showApprove" title="Terima Permintaan ?" :width="'min(760px,95vw)'">
    <form method="POST" :action="approveAction()" class="text-center space-y-6">
      @csrf @method('PUT')
      <p>Terima permintaan <b x-text="target.user"></b> untuk ruangan <b x-text="target.room"></b> ?</p>

      @slot('footer')
      <div class="flex justify-center gap-4">
        <button type="button" @click="reset()" class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow-[0_6px_0_#6b7280]">Batal</button>
        <button type="submit" class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow-[0_6px_0_#4b5563]">OK</button>
      </div>
      @endslot
    </form>
  </x-neo-modal>

  {{-- ==== MODAL TOLAK ==== --}}
  <x-neo-modal show="showReject" title="Tolak Permintaan ?" :width="'min(920px,95vw)'">
    <form method="POST" :action="rejectAction()" class="space-y-6">
      @csrf @method('PUT')
      <p class="text-center">Tolak permintaan <b x-text="target.user"></b> untuk ruangan <b x-text="target.room"></b> ?</p>
      <div>
        <label class="block font-semibold mb-2">Alasan Penolakan (opsional)</label>
        <textarea x-model="rejectReason" name="reason" rows="4"
          class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400"></textarea>
      </div>

      @slot('footer')
      <div class="flex justify-center gap-4">
        <button type="button" @click="reset()" class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow-[0_6px_0_#6b7280]">Batal</button>
        <button type="submit" class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow-[0_6px_0_#4b5563]">OK</button>
      </div>
      @endslot
    </form>
  </x-neo-modal>
</div>
@endsection
