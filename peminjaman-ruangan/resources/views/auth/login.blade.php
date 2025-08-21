<x-guest-layout>
  <div class="desktop-center">
    <div class="scale-wrap">
    <div class="desktop-canvas">
      <div class="login-wrap">
        {{-- PANEL KIRI --}}
        <div class="left-pane">
          <img src="/img/infomedialogo.png" class="h-10 w-auto mb-6" alt="infomedia">
          <h2 class="notice-title">REGISTRATION NOTICE</h2>
          <p class="notice-lead">Untuk menjaga ketertiban data pengguna, registrasi akun hanya dilakukan melalui admin resmi. Ikuti langkah berikut:</p>
          <ol class="notice-list">
            <li>Jika anda ingin melakukan registrasi, silahkan hubungi admin melalui <a href="#" class="font-semibold text-[#25D366] underline">WhatsApp</a> terlebih dahulu.</li>
            <li>Jangan mengisi data sembarangan, ikuti panduan pendaftaran yang diberikan oleh admin.</li>
            <li>Jangan membuat akun lebih dari satu, gunakan satu akun resmi untuk keperluan pinjaman.</li>
            <li>Jangan mengabaikan pesan verifikasi dari admin, pastikan anda mendapat konfirmasi sebelum login.</li>
          </ol>
        </div>

        {{-- PANEL KANAN --}}
        <div class="right-pane">
          <div class="flex items-center gap-3 mb-6">
            <img src="/img/almira.svg" class="h-12 w-auto" alt="">
            <div>
            </div>
          </div>

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
              <div class="field-label">Username</div>
              <div class="neo-field">
                <div class="neo-inner">
                  <input type="email" name="email" class="neo-input" required>
                  <svg class="neo-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"/></svg>
                </div>
              </div>
            </div>

            <div class="field">
              <div class="field-label">Password</div>
              <div class="neo-field">
                <div class="neo-inner">
                  <input type="password" name="password" class="neo-input" placeholder="" required>
                  <svg class="neo-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M2.1 3.51 20.49 21.9l1.41-1.41L3.51 2.1 2.1 3.51zM12 6a9.5 9.5 0 0 1 9.17 7.18A9.52 9.52 0 0 1 17.34 18.9l-1.44-1.44A7.5 7.5 0 0 0 19.3 11 7.5 7.5 0 0 0 12 6z"/></svg>
                </div>
              </div>
            </div>

            <div class="btn-wrap">
              <button class="neo-btn" type="submit">Login</button>
              <div class="btn-shelf"></div>
            </div>
          </form>
        </div>
      </div>

      <div class="login-copy">© 2025 infomedia</div>
    </div>
  </div>
</x-guest-layout>
