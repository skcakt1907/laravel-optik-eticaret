@extends('admin.layout')
@section('title', 'Sipariş ' . $order->order_no)

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-a mb-4">
            <h3 style="font-size:1.05rem;margin-top:0">Ürünler</h3>
            <table class="table-a">
                <thead><tr><th>Ürün</th><th>Adet</th><th>Birim</th><th>Toplam</th></tr></thead>
                <tbody>
                @foreach($order->items as $it)
                    <tr><td>{{ $it->name }}<br><small class="text-muted">{{ $it->sku }}</small></td><td>{{ $it->qty }}</td><td>{{ money($it->price) }}</td><td>{{ money($it->total) }}</td></tr>
                @endforeach
                <tr><td colspan="3" class="text-end">Ara Toplam</td><td>{{ money($order->subtotal) }}</td></tr>
                <tr><td colspan="3" class="text-end">Kargo</td><td>{{ $order->shipping > 0 ? money($order->shipping) : 'Ücretsiz' }}</td></tr>
                <tr><td colspan="3" class="text-end"><strong>Genel Toplam</strong></td><td><strong>{{ money($order->total) }}</strong></td></tr>
                </tbody>
            </table>
        </div>

        <div class="card-a">
            <h3 style="font-size:1.05rem;margin-top:0">Müşteri & Teslimat</h3>
            <p style="margin:0">
                <strong>{{ $order->name }}</strong><br>
                {{ $order->email }} — {{ $order->phone }}<br>
                {{ $order->address }}<br>
                {{ $order->district }} / {{ $order->city }}
            </p>
            @if($order->note)<p class="mt-2"><strong>Not:</strong> {{ $order->note }}</p>@endif
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-a form-a">
            <h3 style="font-size:1.05rem;margin-top:0">Durum Güncelle</h3>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf @method('PATCH')
                <label>Sipariş Durumu</label>
                <select name="status">
                    @foreach($labels as $k => $v)<option value="{{ $k }}" @selected($order->status==$k)>{{ $v }}</option>@endforeach
                </select>
                <label>Ödeme Durumu</label>
                <select name="payment_status">
                    <option value="pending" @selected($order->payment_status=='pending')>Bekliyor</option>
                    <option value="paid" @selected($order->payment_status=='paid')>Ödendi</option>
                    <option value="failed" @selected($order->payment_status=='failed')>Başarısız</option>
                </select>
                <button class="btn-a mt-3 w-100"><i class="bi bi-check-lg"></i> Güncelle</button>
            </form>
            <hr>
            <p style="margin:0;font-size:.88rem"><strong>Ödeme Yöntemi:</strong> {{ ucfirst($order->payment_method) }}<br><strong>Tarih:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
        </div>
    </div>
</div>
@endsection
