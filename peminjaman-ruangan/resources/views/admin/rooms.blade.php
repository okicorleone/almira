@extends('layouts.admin')
@section('title','Manajemen Ruangan')

@section('content')
<div x-data="roomsPage()">
  {{-- Judul --}}
  <h1 class="page-pill">Manajemen Ruangan</h1>

  {{-- ==== Toolbar: Search + Tambah ==== --}}
  <div class="toolbar mt-6 mb-4 flex items-center justify-between gap-3">
    {{-- Search --}}
    <x-search :route="route('admin.rooms.index')" name="search" :value="request('search')" />

    {{-- Tombol Tambah --}}
    <a href="#" class="btn-soft" @click.prevent="openAdd()">
      <span>Tambah</span>
      <svg class="btn-ico" viewBox="0 0 24 24" fill="currentColor">
        <path d="M11 5h2v14h-2zM5 11h14v2H5z"/>
      </svg>
    </a>
  </div>

  {{-- ==== TABEL ==== --}}
  <section class="neo-card p-0 overflow-hidden">
    <div class="max-h-[500px] overflow-y-auto">
      {{-- Header tabel custom --}}
      <div class="px-6 pt-5 pb-2">
        <div class="grid grid-cols-12 gap-4">
          <div class="col-span-4"><div class="th-pill">Nama Ruangan</div></div>
          <div class="col-span-2"><div class="th-pill">Lantai</div></div>
          <div class="col-span-4"><div class="th-pill">Deskripsi Ruangan</div></div>
          <div class="col-span-2"><div class="th-pill">Aksi</div></div>
        </div>
      </div>

      <div class="divider mx-4"></div>

      {{-- Body tabel --}}
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

      {{-- Pagination --}}
      @if(method_exists($rooms, 'links'))
        <div class="px-6 py-4">
          {{ $rooms->withQueryString()->links() }}
        </div>
      @endif
    </div>
  </section>

  {{-- ==== MODAL TAMBAH ==== --}}
  <x-neo-modal show="showAdd" title="Tambahkan<br>Ruangan">
    <form method="POST" action="{{ route('admin.rooms.store') }}" class="space-y-6">
      @csrf
      <div>
        <label class="block font-semibold text-xl mb-2">Nama Ruangan</label>
        <input x-model="formAdd.nama" name="nama" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Lantai</label>
        <input x-model="formAdd.lantai" name="lantai" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Deskripsi Ruangan</label>
        <textarea x-model="formAdd.deskripsi" name="deskripsi" rows="4"
                  class="w-full rounded-2xl bg-neutral-300/80 shadow px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400"></textarea>
      </div>

      <div class="flex justify-center gap-4">
        <button type="button" @click="reset()"
                class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow">Batal</button>
        <button type="submit"
                class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow">OK</button>
      </div>
    </form>
  </x-neo-modal>

  {{-- ==== MODAL EDIT ==== --}}
  <x-neo-modal show="showEdit" title="Edit Ruangan">
    <form method="POST" :action="editAction()" class="space-y-6" id="formEdit">
      @csrf
      @method('PUT')
      <div>
        <label class="block font-semibold text-xl mb-2">Nama Ruangan</label>
        <input x-model="formEdit.nama" name="nama" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Lantai</label>
        <input x-model="formEdit.lantai" name="lantai" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Deskripsi Ruangan</label>
        <textarea x-model="formEdit.deskripsi" name="deskripsi" rows="4"
                  class="w-full rounded-2xl bg-neutral-300/80 shadow px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400"></textarea>
      </div>
      <div class="flex justify-center gap-4">
        <button type="button" @click="reset()"
                class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow">Batal</button>
        <button type="submit"
                class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow">OK</button>
      </div>
    </form>
  </x-neo-modal>

  {{-- ==== MODAL HAPUS ==== --}}
  <x-neo-modal show="showDelete" title="Yakin ?" :width="'min(760px,95vw)'">
    <div class="text-center">
      <div class="mx-auto mb-4 grid h-20 w-20 place-items-center rounded-full border-4 border-emerald-400">
        <span class="text-5xl leading-none text-emerald-500">?</span>
      </div>
      <p class="text-gray-600 mb-6">
        Anda yakin akan menghapus ruangan “<span x-text="del.nama"></span>”?
      </p>

      <form method="POST" :action="deleteAction()" class="flex justify-center gap-4">
        @csrf
        @method('DELETE')
        <button type="button" @click="reset()"
                class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow">Batal</button>
        <button type="submit"
                class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow">OK</button>
      </form>
    </div>
  </x-neo-modal>
</div>
@endsection

@push('scripts')
  @vite(['resources/js/rooms.js'])
@endpush
