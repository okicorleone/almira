@props([
  'show' => '',        // contoh: showAdd
  'title' => '',       // judul modal (boleh pakai <br>)
  'width' => 'min(920px,95vw)',
  'onclose' => 'reset()',
])

{{-- Backdrop --}}
<div x-show="{{ $show }}" x-cloak
     class="fixed inset-0 z-[60] bg-black/40" @click="{{ $onclose }}"
     x-transition.opacity></div>

{{-- Panel --}}
<div x-show="{{ $show }}" x-cloak
     class="fixed inset-0 z-[70] grid place-items-center p-4"
     x-transition>
  <div class="w-[{{ $width }}] rounded-[28px] bg-white p-6 md:p-8 shadow-2xl">
    @if($title)
      <h2 class="text-3xl font-extrabold text-center mb-6">{!! $title !!}</h2>
    @endif

    {{ $slot }}

    @isset($footer)
      <div class="mt-8">
        {{ $footer }}
      </div>
    @endisset
  </div>
</div>
