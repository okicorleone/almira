@props(['route' => '', 'name' => 'q', 'value' => ''])

<form action="{{ $route }}" method="GET"
      class="search"
      x-data="{ open:false, text:'{{ $value }}' }"
      @click.outside="open=false">
  <div class="search-wrap" :class="{ 'open': open }">
    
    {{-- Tombol kaca pembesar --}}
    <button type="button" class="search-btn" @click="open = true">
      <svg class="search-ico" viewBox="0 0 24 24" fill="currentColor">
        <path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 1 0-.7.7l.3.3v.8L20 21.5 21.5 20 15.5 14Zm-6 0a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Z"/>
      </svg>
    </button>

    {{-- Input search --}}
    <template x-if="open">
      <input type="text"
             name="{{ $name }}"
             placeholder="Search..."
             x-model="text"
             class="search-input">
    </template>

    {{-- Tombol close (X) --}}
    <template x-if="open">
      <button type="button" class="search-close"
              @click="open=false; text=''">×</button>
    </template>

  </div>
</form>
