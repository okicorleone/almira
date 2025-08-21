<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  @stack('head')
</head>
<body class="min-h-screen bg-[#F1F2F4] antialiased">
  {{-- SLOT = isi halaman login kamu --}}
  {{ $slot }}
</body>
</html>
