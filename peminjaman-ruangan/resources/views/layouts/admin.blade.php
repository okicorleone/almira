{{-- resources/views/layouts/admin.blade.php --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Admin')</title>

  {{-- muat CSS/JS khusus admin --}}
  @vite(['resources/css/admin.css','resources/js/admin.js'])
  @stack('head')
</head>
<body class="bg-[#F1F2F4] text-[#2B2B2B] min-h-screen">
  <main class="p-6">
    @yield('content')
  </main>
  @stack('scripts')
</body>
</html>
