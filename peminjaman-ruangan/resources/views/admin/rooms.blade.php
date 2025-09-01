@extends('layouts.admin')
@section('title','Manajemen Ruangan')

@section('content')
<div x-data="roomsPage()">
  <h1 class="page-pill">Manajemen Ruangan</h1>

  <div class="toolbar mt-6 mb-4 flex items-center justify-between gap-3">
    <form action="{{ url('/admin/rooms') }}" method="GET" class="search">
      <div class="search-wrap">
        <svg class="search-ico" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 1 0-.7.7l.3.3v.8L20 21.5 21.5 20 15.5 14Zm-6 0a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Z"/>
        </svg>
        <input type="text" name="q" placeholder="Cari ruangan…" class="search-input" value="{{ request('q') }}">
      </div>
    </form>

    <a href="#" class="btn-soft" @click.prevent="openAdd()">
      <span>Tambah</span>
      <svg class="btn-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M11 5h2v14h-2zM5 11h14v2H5z"/></svg>
    </a>
  </div>

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
          @php
            $rows = [
              ['id'=>1,'name'=>'Ruangan Meeting 1','floor'=>1,'desc'=>'Kap 5 org , AC, TV'],
              ['id'=>2,'name'=>'Ruangan Meeting 2','floor'=>2,'desc'=>'AC, TV'],
              ['id'=>3,'name'=>'Ruangan Meeting 3','floor'=>3,'desc'=>'TV, Soundsystem'],
              ['id'=>4,'name'=>'Ruangan Meeting 4','floor'=>4,'desc'=>'Papan Tulis'],
              ['id'=>5,'name'=>'Ruangan Meeting 5','floor'=>5,'desc'=>'AC'],
            ];
          @endphp
          @foreach($rows as $r)
            <tr>
              <td class="py-5 px-6 w-[33%]">{{ $r['name'] }}</td>
              <td class="py-5 px-6 w-[17%] text-center">{{ $r['floor'] }}</td>
              <td class="py-5 px-6 w-[33%]">{{ $r['desc'] }}</td>
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
          @endforeach
        </tbody>
      </table>
    </div>
  </section>

  {{-- ===== MODALS ===== --}}

  {{-- TAMBAH --}}
  <x-neo-modal show="showAdd" title="Tambahkan<br>Ruangan">
    <form method="POST" action="{{ url('/admin/rooms') }}" class="space-y-6">
      @csrf
      <div>
        <label class="block font-semibold text-xl mb-2">Nama Ruangan</label>
        <input x-model="formAdd.name" name="name" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Lantai</label>
        <input x-model="formAdd.floor" name="floor" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Deskripsi Ruangan</label>
        <textarea x-model="formAdd.description" name="description" rows="4"
                  class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400"></textarea>
      </div>

      @slot('footer')
      <div class="flex justify-center gap-4">
        <button type="button" @click="reset()"
                class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow-[0_6px_0_#6b7280]">Batal</button>
        <button type="submit"
                class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow-[0_6px_0_#4b5563]">OK</button>
      </div>
      @endslot
    </form>
  </x-neo-modal>

  {{-- EDIT --}}
  <x-neo-modal show="showEdit" title="Edit Ruangan">
    <form method="POST" :action="editAction()" class="space-y-6" id="formEdit">
      @csrf
      @method('PUT')
      <div>
        <label class="block font-semibold text-xl mb-2">Nama Ruangan</label>
        <input x-model="formEdit.name" name="name" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Lantai</label>
        <input x-model="formEdit.floor" name="floor" required
               class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400">
      </div>
      <div>
        <label class="block font-semibold text-xl mb-2">Deskripsi Ruangan</label>
        <textarea x-model="formEdit.description" name="description" rows="4"
                  class="w-full rounded-2xl bg-neutral-300/80 shadow-[0_6px_0_#9ca3af] px-4 py-3 outline-none focus:ring-2 focus:ring-gray-400"></textarea>
      </div>

      @slot('footer')
      <div class="flex justify-center gap-4">
        <button type="button" @click="reset()"
                class="rounded-2xl bg-gray-500 text-white px-8 py-3 text-xl shadow-[0_6px_0_#6b7280]">Batal</button>
        <button type="submit"
                class="rounded-2xl bg-gray-700 text-white px-8 py-3 text-xl shadow-[0_6px_0_#4b5563]">OK</button>
      </div>
      @endslot
    </form>
  </x-neo-modal>

  {{-- HAPUS --}}
  <x-neo-modal show="showDelete" title="Yakin ?" :width="'min(760px,95vw)'">
    <div class="text-center">
      <div class="mx-auto mb-4 grid h-20 w-20 place-items-center rounded-full border-4 border-emerald-400">
        <span class="text-5xl leading-none text-emerald-500">?</span>
      </div>
      <p class="text-gray-600 mb-6">Anda yakin akan menghapus ruangan “<span x-text="del.name"></span>”?</p>

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
  {{-- muat JS halaman via Vite (tanpa CDN Alpine, Alpine sudah di app.js) --}}
  @vite(['resources/js/rooms.js'])
@endpush
