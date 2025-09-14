@extends('layouts.user')
@section('title','Pengajuan Saya')

@section('content')
  <h1 class="page-pill">Pengajuan Saya</h1>

  <div class="board">
    <div class="neo-card overflow-x-auto">
      <table class="loan-table">
        <thead>
          <tr>
            <th>Tanggal Booking</th>
            <th>Tanggal Peminjaman</th>
            <th>Nama Ruangan</th>
            <th>Agenda</th>
            <th>Jumlah Peserta</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>List Kebutuhan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($loans as $loan)
            <tr>
              <td>{{ \Carbon\Carbon::parse($loan->created_at)->format('d/m/Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') }}</td>
              <td>{{ $loan->room_id }}</td>
              <td>{{ $loan->agenda }}</td>
              <td>{{ $loan->jumlah_peserta }}</td>
              <td>{{ $loan->jam_mulai }}</td>
              <td>{{ $loan->jam_selesai }}</td>
              <td>{{ $loan->kebutuhan }}</td>
              <td>
                @if($loan->status == 'disetujui')
                  <span class="status-pill status-yes">Disetujui</span>
                @elseif($loan->status == 'ditolak')
                  <span class="status-pill status-no">Ditolak</span>
                @else
                  <span class="status-pill status-wait">Menunggu</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center py-4">Belum ada pengajuan</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
