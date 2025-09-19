@extends('layouts.admin')
@section('title','Registrasi Pengguna')

@section('content')
<div x-data="manageUsersPage()">
  <h1 class="page-pill">Registrasi Pengguna</h1>

  <!-- Toolbar: tombol tambah -->
  <div class="mt-6 mb-4 flex items-center justify-center">
    <a href="#" class="btn-soft" @click.prevent="openAdd()">
      <span>Tambah Pengguna</span>
      <svg class="btn-ico" viewBox="0 0 24 24" fill="currentColor">
        <path d="M11 5h2v14h-2zM5 11h14v2H5z"/>
      </svg>
    </a>
  </div>

  <!-- Tabel daftar pengguna -->
  <section class="neo-card p-0 overflow-hidden">
    <div class="table-wrap max-h-[500px] overflow-y-auto">
      <table class="neo-table w-full">
          <tr>
            <th class="py-3 px-6 text-left">
              <div class="th-pill">Nama Lengkap</div>
            </th>
            <th class="py-3 px-6 text-left">
              <div class="th-pill">Departemen</div>
            </th>
            <th class="py-3 px-6 text-left">
              <div class="th-pill">Alamat Email</div>
            </th>
            <th class="py-3 px-6 text-left">
              <div class="th-pill">Aksi</div>
            </th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
            <tr>
              <td class="py-6 px-8 w-[33%]">{{ $u->name }}</td>
              <td class="py-6 px-8 w-[25%]">{{ $u->role }}</td>
              <td class="py-6 px-8 w-[25%]">{{ $u->email }}</td>
              <td class="py-6 px-8 w-[17%]">
                <div class="flex items-center gap-6">
                  <a href="#" class="action-link action-link--delete"
                     @click.prevent='openDelete(@json($u))'>Hapus</a>
                  <a href="#" class="action-link action-link--edit"
                     @click.prevent='openEdit(@json($u))'>Edit</a>
                </div>
              </td>
            </tr>
            <tr><td colspan="4"><div class="divider mx-4"></div></td></tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-gray-500 py-6">
                Belum ada data pengguna.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

  {{-- ====== MODALS ====== --}}

  {{-- TAMBAH --}}
  <x-neo-modal show="showAdd" title="Form Tambah Pengguna" :width="'min(760px,95vw)'">
    <form method="POST" action="{{ route('admin.manageuser.store') }}" class="space-y-6">
      @csrf

      <!-- Username -->
      <div class="relative">
        <input x-model="formAdd.name" name="name" required placeholder="Username"
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 pr-12 outline-none focus:ring-2 focus:ring-gray-400">
        <span class="absolute right-4 top-1/2 -translate-y-1/2 opacity-70">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.33 0-8 2.17-8 5v1h16v-1c0-2.83-3.67-5-8-5Z"/></svg>
        </span>
      </div>

      <!-- Password -->
      <div class="relative">
        <input x-model="formAdd.password" name="password" type="password" required placeholder="Password"
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 pr-12 outline-none focus:ring-2 focus:ring-gray-400">
        <span class="absolute right-4 top-1/2 -translate-y-1/2 opacity-70">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17 8h-1V6a4 4 0 0 0-8 0v2H7a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1Zm-7-2a2 2 0 0 1 4 0v2H10Zm2 9a2 2 0 1 1 2-2 2 2 0 0 1-2 2Z"/></svg>
        </span>
      </div>

      <!-- Role -->
      <div class="relative">
        <select x-model="formAdd.role" name="role" placeholder="Departemen"
              class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af]
                 px-4 py-3 pr-12 outline-none focus:ring-2 focus:ring-gray-400"required>
            <option value="" disabled selected>Pilih Layanan</option>
          @foreach($roles as $role)
            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
          @endforeach
        </select>
        <span class="absolute right-4 top-1/2 -translate-y-1/2 opacity-70">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M3 3h18v4H3Zm0 6h18v12H3Zm2 2v8h14v-8Z"/></svg>
        </span>
      </div>

      <!-- Email -->
      <div class="relative">
        <input x-model="formAdd.email" name="email" type="email" placeholder="Alamat Email"
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 pr-12 outline-none focus:ring-2 focus:ring-gray-400">
        <span class="absolute right-4 top-1/2 -translate-y-1/2 opacity-70">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 13 2 6.76V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v.76ZM2 8.24 12 15l10-6.76V18a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2Z"/></svg>
        </span>
      </div>

      <div class="flex justify-center gap-4">
        <button type="button" @click="reset()"
                class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow-[0_6px_0_#6b7280]">Batal</button>
        <button type="submit"
                class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow-[0_6px_0_#4b5563]">Ok</button>
      </div>
    </form>
  </x-neo-modal>

  {{-- EDIT --}}
  <x-neo-modal show="showEdit" title="Edit Pengguna" :width="'min(760px,95vw)'">
    <form method="POST" :action="editAction()" class="space-y-6" id="formEdit">
      @csrf @method('PUT')

      <div class="relative">
        <input x-model="formEdit.name" name="name" required placeholder="Username"
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 pr-12 outline-none focus:ring-2 focus:ring-gray-400">
        <span class="absolute right-4 top-1/2 -translate-y-1/2 opacity-70">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.33 0-8 2.17-8 5v1h16v-1c0-2.83-3.67-5-8-5Z"/></svg>
        </span>
      </div>

      <div class="relative">
        <select x-model="formEdit.role" name="role"
          class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af]
                 px-4 py-3 pr-12 outline-none focus:ring-2 focus:ring-gray-400"required>
          <option value="" disabled selected>Pilih Layanan</option>
          @foreach($roles as $role)
            <option value="{{ $role }}">{{ $role }}</option>
          @endforeach
        </select>
        <span class="absolute right-4 top-1/2 -translate-y-1/2 opacity-70">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M3 3h18v4H3Zm0 6h18v12H3Zm2 2v8h14v-8Z"/>
          </svg>
        </span>
      </div>

      <div class="relative">
        <input x-model="formEdit.email" name="email" type="email" placeholder="Alamat Email"
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 pr-12 outline-none focus:ring-2 focus:ring-gray-400">
        <span class="absolute right-4 top-1/2 -translate-y-1/2 opacity-70">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 13 2 6.76V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v.76ZM2 8.24 12 15l10-6.76V18a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2Z"/></svg>
        </span>
      </div>

      <div class="flex justify-center gap-4">
        <button type="button" @click="reset()"
                class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow-[0_6px_0_#6b7280]">Batal</button>
        <button type="submit"
                class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow-[0_6px_0_#4b5563]">Ok</button>
      </div>
    </form>
  </x-neo-modal>

  {{-- HAPUS --}}
  <x-neo-modal show="showDelete" title="Yakin ?" :width="'min(760px,95vw)'">
    <div class="text-center">
      <div class="mx-auto mb-4 grid h-20 w-20 place-items-center rounded-full border-4 border-emerald-400">
        <span class="text-5xl leading-none text-emerald-500">?</span>
      </div>
      <p class="text-gray-600 mb-6">Hapus pengguna “<span x-text="del.name"></span>”?</p>

      <form method="POST" :action="deleteAction()" class="flex justify-center gap-4">
        @csrf @method('DELETE')
        <button type="button" @click="reset()"
                class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow-[0_6px_0_#6b7280]">Batal</button>
        <button type="submit"
                class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow-[0_6px_0_#4b5563]">Ok</button>
      </form>
    </div>
  </x-neo-modal>
</div>
@endsection

@push('scripts')
  @vite(['resources/js/manage_users.js'])
@endpush
