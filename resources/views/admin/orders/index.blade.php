@extends('admin.layout')
@section('title', 'Siparişler')

@section('content')
<form method="GET" class="d-flex gap-2 mb-3">
    <input name="q" value="{{ request('q') }}" placeholder="Sipariş no / müşteri..." style="padding:.5rem .8rem;border:1px solid var(--aline);border-radius:9px">
    <select name="durum" onchange="this.form.submit()" style="padding:.5rem .8rem;border:1px solid var(--aline);border-radius:9px">
        <option value="">Tüm Durumlar</option>
        @foreach($labels as $k => $v)<option value="{{ $k }}" @selected(request('durum')==$k)>{{ $v }}</option>@endforeach
    </select>
    <button class="btn-a sec"><i class="bi bi-search"></i></button>
</form>

<table class="table-a">
    <thead><tr><th>Sipariş No</th><th>Müşteri</th><th>Tutar</th><th>Ödeme</th><th>Durum</th><th>Tarih</th><th></th></tr></thead>
    <tbody>
    @forelse($orders as $o)
        <tr>
            <td><strong>{{ $o->order_no }}</strong></td>
            <td>{{ $o->name }}<br><small class="text-muted">{{ $o->phone }}</small></td>
            <td>{{ money($o->total) }}</td>
            <td>{{ ucfirst($o->payment_method) }}<br><span class="pill {{ $o->payment_status }}">{{ ['pending'=>'Bekliyor','paid'=>'Ödendi','failed'=>'Başarısız'][$o->payment_status] ?? $o->payment_status }}</span></td>
            <td><span class="pill {{ $o->status }}">{{ $o->status_label }}</span></td>
            <td>{{ $o->created_at->format('d.m.Y H:i') }}</td>
            <td><a href="{{ route('admin.orders.show', $o) }}" class="btn-a sec sm">Detay</a></td>
        </tr>
    @empty
        <tr><td colspan="7" class="text-center text-muted py-4">Sipariş bulunamadı.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
