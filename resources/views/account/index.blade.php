@extends('layouts.app')
@section('title', 'Hesabım — ' . setting('site_adi'))

@section('content')
<section class="page-head"><div class="container"><h1>Hesabım</h1></div></section>

<section style="padding-top:50px">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">@include('account.nav')</div>
            <div class="col-lg-9">
                <div class="row g-4 mb-4">
                    <div class="col-md-6"><div class="side-card"><h4 style="font-size:.85rem;text-transform:uppercase;color:var(--gray)">Toplam Sipariş</h4><div style="font-size:2rem;font-weight:800;color:var(--ink)">{{ $orderCount }}</div></div></div>
                    <div class="col-md-6"><div class="side-card"><h4 style="font-size:.85rem;text-transform:uppercase;color:var(--gray)">Üyelik</h4><div style="font-weight:700;color:var(--ink)">{{ $user->name }}</div><small style="color:var(--gray)">{{ $user->email }}</small></div></div>
                </div>

                <div class="side-card mb-4">
                    <h4>Bilgilerimi Güncelle</h4>
                    <form action="{{ route('account.update') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Ad Soyad</label><input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required></div>
                            <div class="col-md-6"><label class="form-label">Telefon</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"></div>
                            <div class="col-md-6"><label class="form-label">Yeni Şifre</label><input type="password" name="password" class="form-control" placeholder="Değiştirmek istemiyorsanız boş bırakın"></div>
                            <div class="col-md-6"><label class="form-label">Yeni Şifre (Tekrar)</label><input type="password" name="password_confirmation" class="form-control"></div>
                            <div class="col-12"><button class="btn btn-orange">Güncelle</button></div>
                        </div>
                    </form>
                </div>

                @if($lastOrders->count())
                <div class="side-card">
                    <h4>Son Siparişler</h4>
                    @foreach($lastOrders as $o)
                        <div class="order-row d-flex justify-content-between align-items-center">
                            <div><strong>{{ $o->order_no }}</strong><br><small style="color:var(--gray)">{{ $o->created_at->format('d.m.Y') }}</small></div>
                            <div class="text-end"><span class="status-pill {{ $o->status }}">{{ $o->status_label }}</span><br><strong>{{ money($o->total) }}</strong></div>
                            <a href="{{ route('account.order', $o->order_no) }}" class="btn btn-line btn-sm">Detay</a>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
