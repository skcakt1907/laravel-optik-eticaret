<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Yönetim') — {{ setting('site_adi') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}" rel="stylesheet">
</head>
<body>
<div class="admin-wrap">
    <aside class="admin-side" id="aside">
        <div class="brand">Limon<span>Optik</span> · Yönetim</div>
        <nav>
            @php $r = request()->route()->getName(); @endphp
            <a href="{{ route('admin.dashboard') }}" class="{{ $r==='admin.dashboard'?'active':'' }}"><i class="bi bi-speedometer2"></i> Panel</a>
            <div class="sec">Katalog</div>
            <a href="{{ route('admin.products.index') }}" class="{{ str_starts_with($r,'admin.products')?'active':'' }}"><i class="bi bi-box-seam"></i> Ürünler</a>
            <a href="{{ route('admin.categories.index') }}" class="{{ str_starts_with($r,'admin.categories')?'active':'' }}"><i class="bi bi-tags"></i> Kategoriler</a>
            <div class="sec">Satış</div>
            <a href="{{ route('admin.orders.index') }}" class="{{ str_starts_with($r,'admin.orders')?'active':'' }}"><i class="bi bi-receipt"></i> Siparişler</a>
            <a href="{{ route('admin.appointments.index') }}" class="{{ str_starts_with($r,'admin.appointments')?'active':'' }}"><i class="bi bi-calendar-check"></i> Randevular</a>
            @php $unreadMsg = \App\Models\ContactMessage::unread()->count(); @endphp
            <a href="{{ route('admin.messages.index') }}" class="{{ str_starts_with($r,'admin.messages')?'active':'' }}"><i class="bi bi-envelope"></i> Mesajlar @if($unreadMsg)<span class="badge bg-danger ms-1">{{ $unreadMsg }}</span>@endif</a>
            <div class="sec">Sistem</div>
            <a href="{{ route('admin.settings.edit') }}" class="{{ str_starts_with($r,'admin.settings')?'active':'' }}"><i class="bi bi-gear"></i> Ayarlar</a>
            <a href="{{ route('admin.profile.edit') }}" class="{{ str_starts_with($r,'admin.profile')?'active':'' }}"><i class="bi bi-person-gear"></i> Profil</a>
            <a href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Siteyi Gör</a>
        </nav>
    </aside>

    <div class="admin-main">
        <div class="admin-top">
            <div class="d-flex align-items-center gap-2">
                <button class="btn-a sec sm d-md-none" onclick="document.getElementById('aside').classList.toggle('open')"><i class="bi bi-list"></i></button>
                <h1>@yield('title', 'Yönetim Paneli')</h1>
            </div>
            <div class="right">
                <a href="{{ route('admin.profile.edit') }}" title="Profil"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</a>
                <a href="#" onclick="event.preventDefault();document.getElementById('lg').submit()"><i class="bi bi-box-arrow-right"></i> Çıkış</a>
                <form id="lg" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>
        <div class="admin-body">
            @if(session('success'))<div class="alert-a">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert-a err">{{ session('error') }}</div>@endif
            @if($errors->any())<div class="alert-a err">{{ $errors->first() }}</div>@endif
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
