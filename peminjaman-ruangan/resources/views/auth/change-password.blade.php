@extends('layouts.admin')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Ubah Password</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="block">Password Lama</label>
            <input type="password" name="current_password" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-3">
            <label class="block">Password Baru</label>
            <input type="password" name="new_password" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-3">
            <label class="block">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" class="w-full border rounded p-2" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
</div>
@endsection
