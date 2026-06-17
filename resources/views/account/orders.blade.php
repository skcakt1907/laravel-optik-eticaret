@extends('layouts.app')
@section('title', 'Siparişlerim — ' . setting('site_adi'))

@section('content')
<section class="page-head"><div class="container"><h1>Siparişlerim</h1></div></section>

<section style="padding-top:50px">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">@include('account.nav')</div>
            <div class="col-lg-9">
                @forelse($orders as $o)
                    <div class="order-row d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div><small style="color:var(--gray)">Sipariş No</small><br><strong>{{ $o->order_no }}</strong></div>
                        <div><small style="color:var(--gray)">Tarih</small><br>{{ $o->created_at->format('d.m.Y') }}</div>
                        <div><small style="color:var(--gray)">Tutar</small><br><strong>{{ money($o->total) }}</strong></div>
                        <div><span class="status-pill {{ $o->status }}">{{ $o->status_label }}</span></div>
                        <a href="{{ route('account.order', $o->order_no) }}" class="btn btn-line">Detay</a>
                    </div>
                @empty
                    <div class="empty-state"><i class="bi bi-bag"></i><h3>Henüz siparişiniz yok</h3><a href="{{ route('shop') }}" class="btn btn-orange">Alışverişe Başla</a></div>
                @endforelse
                <div class="mt-4">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
</section>
@endsection
