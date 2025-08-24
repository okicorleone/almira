<x-guest-layout>
  <div class="min-h-screen grid place-items-center bg-[#F1F2F4] px-4 py-10">
    <div class="w-full max-w-[1180px]">
      <div class="almira-shell">

        {{-- KIRI: REGISTRATION NOTICE (abu muda) --}}
        <aside class="notice-card">
          <img src="/img/infomedialogo.png" alt="Infomedia" class="h-14 w-auto mb-5">
          <h2 class="text-[22px] font-extrabold text-[#ED1C24] uppercase tracking-wide mb-3">
            Registration Notice
          </h2>
          <p class="text-[13px] text-[#232323]/85 leading-relaxed mb-3">
            Untuk menjaga ketertiban data pengguna, registrasi akun hanya dilakukan melalui admin resmi.
            Ikuti langkah‑langkah berikut ini:
          </p>
          <ol class="list-decimal pl-5 space-y-2 text-[13px] text-[#232323]/85">
            <li>Jika anda ingin melakukan registrasi, silahkan hubungi admin melalui
              <a href="#" class="text-[#27AE60] font-semibold">WhatsApp</a> terlebih dahulu.</li>
            <li>Jangan mengisi data sembarangan, ikuti panduan pendaftaran yang diberikan oleh admin.</li>
            <li>Jangan membuat akun lebih dari satu, gunakan satu akun resmi untuk keperluan pinjaman.</li>
            <li>Jangan mengabaikan pesan verifikasi dari admin, pastikan anda mendapat konfirmasi sebelum login.</li>
          </ol>

          <span class="notice-shadow"></span>
        </aside>

        {{-- KANAN: logo tunggal + form --}}
        <main class="form-side">
          <img src="/img/almira.svg" alt="Almira" class="h-[150px] w-auto mb-7 mx">
          <form method="POST" action="{{ route('login') }}" class="w-full max-w-[420px] space-y-4">
            @csrf

            <div class="relative">
              <input type="text" name="email" placeholder="Username" required autocomplete="username" class="almira-input">
              <svg class="input-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.9 0-9 2.5-9 5.6V21h18v-1.4C21 16.5 16.9 14 12 14Z"/>
              </svg>
            </div>

            <div class="relative">
              <input type="password" name="password" placeholder="Password" required autocomplete="current-password" class="almira-input">
              <svg class="input-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M3.11 3.51 4.5 2.1l16.39 16.39-1.41 1.41-2.3-2.3A11.3 11.3 0 0 1 12 20.9C6.26 20.9 1.66 16.86.5 12 1.06 10.1 2.3 8.24 4 6.7L3.11 3.51ZM12 7.1c5.74 0 10.34 4.04 11.5 8.9-.28.95-.7 1.86-1.26 2.7l-2.4-2.4c.69-1 .96-2 .96-2.3C20.8 11.4 16.4 8 12 8c-.3 0-.6 0-.9.04L9.8 6.7c.7-.36 1.4-.6 2.2-.6Z"/>
              </svg>
            </div>

            <div class="flex justify-center pt-1">
              <button type="submit" class="almira-btn">Login</button>
            </div>
          </form>
        </main>
      </div>

      <p class="text-center text-[#8A8A8A] text-xs mt-8">© 2025 infomedia</p>
    </div>
  </div>
</x-guest-layout>