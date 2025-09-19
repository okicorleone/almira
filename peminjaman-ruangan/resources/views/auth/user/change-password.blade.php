@extends('layouts.user')

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

<form action="{{ route('user.password.update') }}" method="POST">
    @csrf
    @method('PUT')


    <div>
        <label>Password Lama</label>
        <input type="password" name="current_password" required>
    </div>

    <div>
        <label>Password Baru</label>
        <input type="password" name="new_password" required>
    </div>

    <div>
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="new_password_confirmation" required>
    </div>

    <button type="submit">Simpan</button>
</form>


</div>
@endsection
