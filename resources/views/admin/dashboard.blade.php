@extends('admin.layout')
@section('title', 'Panel')

@section('content')
<div class="stat-grid">
    <div class="stat-a"><div class="ic"><i class="bi bi-receipt"></i></div><div><div class="v">{{ $orderCount }}</div><div class="l">Toplam Sipariş</div></div></div>
    <div class="stat-a"><div class="ic"><i class="bi bi-hourglass-split"></i></div><div><div class="v">{{ $pendingCount }}</div><div class="l">Yeni Sipariş</div></div></div>
    <div class="stat-a"><div class="ic"><i class="bi bi-cash-stack"></i></div><div><div class="v">{{ money($revenue) }}</div><div class="l">Tahsil Edilen</div></div></div>
    <div class="stat-a"><div class="ic"><i class="bi bi-box-seam"></i></div><div><div class="v">{{ $productCount }}</div><div class="l">Ürün ({{ $lowStock }} düşük stok)</div></div></div>
    <div class="stat-a"><div class="ic"><i class="bi bi-calendar-check"></i></div><div><div class="v">{{ $apptCount }}</div><div class="l">Yeni Randevu</div></div></div>
</div>

<div class="card-a">
    <div class="page-title-row"><h3 style="margin:0;font-size:1.1rem">Son Siparişler</h3><a href="{{ route('admin.orders.index') }}" class="btn-a sec sm">Tümü</a></div>
    <table class="table-a">
        <thead><tr><th>Sipariş No</th><th>Müşteri</th><th>Tutar</th><th>Ödeme</th><th>Durum</th><th>Tarih</th><th></th></tr></thead>
        <tbody>
        @forelse($recentOrders as $o)
            <tr>
                <td><strong>{{ $o->order_no }}</strong></td>
                <td>{{ $o->name }}</td>
                <td>{{ money($o->total) }}</td>
                <td><span class="pill {{ $o->payment_status }}">{{ ['pending'=>'Bekliyor','paid'=>'Ödendi','failed'=>'Başarısız'][$o->payment_status] ?? $o->payment_status }}</span></td>
                <td><span class="pill {{ $o->status }}">{{ $o->status_label }}</span></td>
                <td>{{ $o->created_at->format('d.m.Y') }}</td>
                <td><a href="{{ route('admin.orders.show', $o) }}" class="btn-a sec sm">Gör</a></td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-4">Henüz sipariş yok.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
