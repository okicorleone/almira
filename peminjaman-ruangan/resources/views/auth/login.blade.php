<x-guest-layout>
  <div class="min-h-screen grid place-items-center bg-[#F1F2F4] px-4 py-10">
    <div class="w-full max-w-[1180px]">
      <div class="almira-shell">

        {{-- KIRI: REGISTRATION NOTICE (abu muda) --}}
        <aside class="notice-card">
          <img src="/img/infomedialogo.png" alt="Infomedia" class="h-25 w-25 mt-5">
          <h2 class="text-[25px] font-extrabold text-[#ED1C24] uppercase tracking-wide mt-3">
            Registration Notice
          </h2>
          <p class="text-[13px] text-[#232323]/85 leading-relaxed mb-3 ">
            Untuk menjaga ketertiban data pengguna, registrasi akun hanya dilakukan melalui admin resmi.
            Ikuti langkah‑langkah berikut ini:
          </p>
          <ol class="list-decimal pl-5 space-y-2 text-[13px] text-[#232323]/85">
            <li>Jika anda ingin melakukan registrasi, silahkan hubungi admin melalui
              <a id="whatsappLink" class="text-[#27AE60] font-semibold" target="_blank">WhatsApp </a>terlebih dahulu.
              <script>
                  const phone = "6281312465290";

                  const today = new Date();
                  const year = today.getFullYear();
                  const month = String(today.getMonth() + 1).padStart(2, '0');
                  const day = String(today.getDate()).padStart(2, '0');
                  const currentDate = `${year}-${month}-${day}`;

                  const message = `Halo Admin, saya ingin mendaftarkan akun Almira dengan data diri sebagai berikut:\n
      - Nama Lengkap : [Isi Nama Lengkap]
      - Email : [Isi Alamat Email]
      - Kata Sandi : [Isi Password]
      - Layanan : [Isi Layanan Anda]
      - Email : [Tuliskan Email Aktif Anda]
      - Tanggal Pendaftaran : ${currentDate}\n
Mohon agar data saya dapat diproses untuk pembuatan akun Almira. Terima kasih.`;

                  const encodedMessage = encodeURIComponent(message);
                  const whatsappURL = `https://api.whatsapp.com/send/?phone=${phone}&text=${encodedMessage}&type=phone_number&app_absent=0`;

                  document.getElementById("whatsappLink").setAttribute("href", whatsappURL);
              </script>
            </li>
            <li>Jangan mengisi data sembarangan, ikuti panduan pendaftaran yang diberikan oleh admin.</li>
            <li>Jangan membuat akun lebih dari satu, gunakan satu akun resmi untuk keperluan pinjaman.</li>
            <li>Jangan mengabaikan pesan verifikasi dari admin, pastikan anda mendapat konfirmasi sebelum login.</li>
          </ol>

          <span class="notice-shadow"></span>
        </aside>

        {{-- KANAN: logo tunggal + form --}}
        <main class="form-side">
        <img src="/img/almira.svg" alt="Almira" class="h-[200px] w-auto mb-7 mx-auto">
        <form
           method="POST"
          action="{{ route('login') }}"
           class="w-full max-w-[480px] space-y-4 mx-auto mt-2 lg:-translate-x-6"
   >
    @csrf

            <div class="relative">
              <input type="text" name="email" placeholder="Username" required autocomplete="username" class="almira-input">
              <svg class="input-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.9 0-9 2.5-9 5.6V21h18v-1.4C21 16.5 16.9 14 12 14Z"/>
              </svg>
            </div>

            <div x-data="{ show: false }" class="relative">
  <input :type="show ? 'text' : 'password'" 
         name="password" 
         placeholder="Password" 
         required 
         autocomplete="current-password" 
         class="almira-input pr-10">

  <button type="button" 
          @click="show = !show" 
          class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 focus:outline-none">
    {{-- Eye Open --}}
    <span x-show="show" x-cloak>
      <svg xmlns="http://www.w3.org/2000/svg" 
           fill="none" viewBox="0 0 24 24" stroke="currentColor" 
           class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 
                 8.268 2.943 9.542 7-1.274 4.057-5.065 
                 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
      </svg>
    </span>

    {{-- Eye Slash --}}
    <span x-show="!show" x-cloak>
      <svg xmlns="http://www.w3.org/2000/svg" 
           fill="none" viewBox="0 0 24 24" stroke="currentColor" 
           class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 
                 9.956 0 012.162-3.568M6.22 6.22A9.956 9.956 0 0112 
                 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 
                 0 01-4.293 5.293M15 12a3 3 0 11-6 0 3 3 
                 0 016 0zM3 3l18 18"/>
      </svg>
    </span>
  </button>
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