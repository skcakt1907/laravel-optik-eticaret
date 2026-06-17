<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', setting('site_adi', 'Limon Optik'))</title>
    <meta name="description" content="@yield('meta', setting('site_aciklama'))">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    {{-- Open Graph / Sosyal medya --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ setting('site_adi') }}">
    <meta property="og:title" content="@yield('title', setting('site_adi'))">
    <meta property="og:description" content="@yield('meta', setting('site_aciklama'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('img/logo.png'))">
    <meta property="og:locale" content="tr_TR">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/shop.css') }}?v={{ filemtime(public_path('css/shop.css')) }}" rel="stylesheet">
</head>
<body>
@include('partials.header')

<main>
    @if(session('success'))
        <div class="container mt-3"><div class="alert alert-success">{{ session('success') }}</div></div>
    @endif
    @if(session('error'))
        <div class="container mt-3"><div class="alert alert-danger">{{ session('error') }}</div></div>
    @endif

    @yield('content')
</main>

@include('partials.footer')

<a href="https://wa.me/{{ setting('whatsapp', '905320000000') }}" class="wa-float" target="_blank" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // navbar scroll efekti
    const nav = document.querySelector('.navbar');
    window.addEventListener('scroll', () => nav?.classList.toggle('scrolled', window.scrollY > 20));
    // adet kutusu
    document.querySelectorAll('.qty-box').forEach(box => {
        const input = box.querySelector('input');
        box.querySelector('.qminus')?.addEventListener('click', () => { input.value = Math.max(1, parseInt(input.value||1)-1); input.dispatchEvent(new Event('change')); });
        box.querySelector('.qplus')?.addEventListener('click', () => { input.value = parseInt(input.value||1)+1; input.dispatchEvent(new Event('change')); });
    });
</script>
@stack('scripts')
</body>
</html>
