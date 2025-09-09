@extends('layouts.admin')
@section('title','Manajemen Ruangan')

@section('content')
<div x-data="roomsPage()">
  <h1 class="page-pill">Manajemen Ruangan</h1>

  {{-- Toolbar: Search + Tambah --}}
  <div class="toolbar mt-6 mb-4 flex items-center justify-between gap-3">
    {{-- NOTE: index route dari resource = admin.rooms.index --}}
    <form action="{{ route('admin.rooms.index') }}" method="GET" class="search">
      <div class="search-wrap">
        <svg class="search-ico" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 1 0-.7.7l.3.3v.8L20 21.5 21.5 20 15.5 14Zm-6 0a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Z"/>
        </svg>
        <input type="text" name="search" placeholder="Cari ruangan…" class="search-input"
               value="{{ request('search') }}">
      </div>
    </form>

    <a href="#" class="btn-soft" @click.prevent="openAdd()">
      <span>Tambah</span>
      <svg class="btn-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M11 5h2v14h-2zM5 11h14v2H5z"/></svg>
    </a>
  </div>

  {{-- Tabel --}}
  <section class="neo-card p-0 overflow-hidden">
    <div class="px-6 pt-5 pb-2">
      <div class="grid grid-cols-12 gap-4">
        <div class="col-span-4"><div class="th-pill">Nama Ruangan</div></div>
        <div class="col-span-2"><div class="th-pill">Lantai</div></div>
        <div class="col-span-4"><div class="th-pill">Deskripsi Ruangan</div></div>
        <div class="col-span-2"><div class="th-pill">Aksi</div></div>
      </div>
    </div>

    <div class="divider mx-4"></div>

    <div class="table-wrap">
      <table class="neo-table">
        <tbody>
          @forelse($rooms as $r)
            <tr>
              <td class="py-5 px-6 w-[33%]">{{ $r->nama }}</td>
              <td class="py-5 px-6 w-[17%] text-center">{{ $r->lantai }}</td>
              <td class="py-5 px-6 w-[33%]">{{ $r->deskripsi }}</td>
              <td class="py-5 px-6 w-[17%]">
                <div class="flex items-center gap-6">
                  <a href="#" class="action-link action-link--edit"
                     @click.prevent='openEdit(@json($r))'>Edit</a>
                  <a href="#" class="action-link action-link--delete"
                     @click.prevent='openDelete(@json($r))'>Hapus</a>
                </div>
              </td>
            </tr>
            <tr><td colspan="4"><div class="divider mx-4"></div></td></tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-gray-500 py-6">
                Belum ada data ruangan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- (opsional) pagination --}}
    @if(method_exists($rooms, 'links'))
      <div class="px-6 py-4">
        {{ $rooms->withQueryString()->links() }}
      </div>
    @endif
  </section>

  {{-- ===== MODALS ===== --}}

  {{-- TAMBAH --}}
  <x-neo-modal show="showAdd" title="Tambahkan<br>Ruangan">
    {{-- NOTE: store route dari resource = admin.rooms.store --}}
    <form method="POST" action="{{ route('admin.rooms.store') }}" class="space-y-6">
      @csrf
      <div>
        <label class="block font-semibold text-xl mb-2">Nama Ruangan</label>
        <input x-model="formAdd.name" name="nama" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Lantai</label>
        <input x-model="formAdd.floor" name="lantai" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Deskripsi Ruangan</label>
        <textarea x-model="formAdd.description" name="deskripsi" rows="4"
                  class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400"></textarea>
      </div>

      <div class="flex justify-center gap-4">
        <button type="button" @click="reset()"
                class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow-[0_6px_0_#6b7280]">Batal</button>
        <button type="submit"
                class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow-[0_6px_0_#4b5563]">OK</button>
      </div>
    </form>
  </x-neo-modal>

  {{-- EDIT --}}
  <x-neo-modal show="showEdit" title="Edit Ruangan">
    {{-- NOTE: update route = admin.rooms.update/{room} (PUT) --}}
    <form method="POST" :action="editAction()" class="space-y-6" id="formEdit">
      @csrf
      @method('PUT')
      <div>
        <label class="block font-semibold text-xl mb-2">Nama Ruangan</label>
        <input x-model="formEdit.name" name="nama" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Lantai</label>
        <input x-model="formEdit.floor" name="lantai" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Deskripsi Ruangan</label>
        <textarea x-model="formEdit.description" name="deskripsi" rows="4"
                  class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400"></textarea>
      </div>
      <div class="flex justify-center gap-4">
        <button type="button" @click="reset()"
                class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow-[0_6px_0_#6b7280]">Batal</button>
        <button type="submit"
                class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow-[0_6px_0_#4b5563]">OK</button>
      </div>
    </form>
  </x-neo-modal>

  {{-- HAPUS --}}
  <x-neo-modal show="showDelete" title="Yakin ?" :width="'min(760px,95vw)'">
    <div class="text-center">
      <div class="mx-auto mb-4 grid h-20 w-20 place-items-center rounded-full border-4 border-emerald-400">
        <span class="text-5xl leading-none text-emerald-500">?</span>
      </div>
      <p class="text-gray-600 mb-6">
        Anda yakin akan menghapus ruangan “<span x-text="del.name"></span>”?
      </p>

      {{-- NOTE: destroy route = admin.rooms.destroy/{room} (DELETE) --}}
      <form method="POST" :action="deleteAction()" class="flex justify-center gap-4">
        @csrf
        @method('DELETE')
        <button type="button" @click="reset()"
                class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow-[0_6px_0_#6b7280]">Batal</button>
        <button type="submit"
                class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow-[0_6px_0_#4b5563]">OK</button>
      </form>
    </div>
  </x-neo-modal>
</div>
@endsection

@push('scripts')
  {{-- muat JS halaman via Vite (Alpine sudah di app.js) --}}
  @vite(['resources/js/rooms.js'])
@endpush
