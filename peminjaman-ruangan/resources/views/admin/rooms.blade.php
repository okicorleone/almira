@extends('layouts.admin')

@section('content')
<h1>Manajemen Ruangan</h1>

<a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Tambah Ruangan</a>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Nama Ruangan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rooms as $room)
        <tr>
            <td>{{ $room->nama }}</td>
            <td>{{ ucfirst($room->status) }}</td>
            <td>
                <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus ruangan ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
