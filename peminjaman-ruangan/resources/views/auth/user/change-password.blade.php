@extends('layouts.user')

@section('content')
<div class="max-w-md mx-auto mt-12">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center flex items-center justify-center gap-2">
            <span class="text-yellow-500">🔒</span> 
            <span>Ubah Password</span>
        </h2>

        {{-- Error alert --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success alert --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-5 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('user.password.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Password Lama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                <input type="password" name="current_password"
                    class="w-full border border-gray-300 rounded-lg p-2.5 placeholder-gray-400 
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan password lama" required>
            </div>

            {{-- Password Baru --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="new_password"
                    class="w-full border border-gray-300 rounded-lg p-2.5 placeholder-gray-400 
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Minimal 8 karakter" required>
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation"
                    class="w-full border border-gray-300 rounded-lg p-2.5 placeholder-gray-400 
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Ulangi password baru" required>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 
                           rounded-lg shadow transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
