<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" alt="{{ setting('site_adi') }}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <i class="bi bi-list fs-2"></i>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Anasayfa</a></li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link {{ request()->routeIs('shop*') ? 'active' : '' }}" href="{{ route('shop') }}">Mağaza <i class="bi bi-chevron-down" style="font-size:.7rem"></i></a>
                    <div class="dropdown-panel">
                        @foreach($navCategories as $cat)
                            <a href="{{ route('shop', ['kategori' => $cat->slug]) }}"><i class="bi {{ $cat->icon ?: 'bi-eyeglasses' }}"></i> {{ $cat->name }}</a>
                        @endforeach
                        {{-- Cinsiyet ayrı bir kategori değil, ürün özelliği; menüde
                             kategori gibi görünsün diye filtreli mağaza linki. --}}
                        <a href="{{ route('shop', ['cinsiyet' => 'Unisex']) }}"><i class="bi bi-people"></i> Unisex</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('brands') ? 'active' : '' }}" href="{{ route('brands') }}">Markalar</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('services*') ? 'active' : '' }}" href="{{ route('services') }}">Hizmetler</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('blog*') ? 'active' : '' }}" href="{{ route('blog') }}">Blog</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Hakkımızda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">İletişim</a></li>

                @auth
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link" href="{{ route('account') }}"><i class="bi bi-person-circle"></i></a>
                        <div class="dropdown-panel" style="min-width:220px">
                            <a href="{{ route('account') }}"><i class="bi bi-person"></i> Hesabım</a>
                            <a href="{{ route('account.orders') }}"><i class="bi bi-bag"></i> Siparişlerim</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Yönetim Paneli</a>
                            @endif
                            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> Çıkış</a>
                        </div>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="bi bi-person-circle"></i></a></li>
                @endauth

                <li class="nav-item">
                    <a class="nav-cart" href="{{ route('cart') }}" title="Sepet">
                        <i class="bi bi-bag"></i>
                        @if($cartCount > 0)<span class="badge">{{ $cartCount }}</span>@endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
