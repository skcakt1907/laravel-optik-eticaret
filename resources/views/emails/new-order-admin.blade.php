@component('emails.layout', ['title' => 'Yeni Sipariş'])
<h1 style="font-size:22px;margin:0 0 6px;">Yeni Sipariş Geldi</h1>
<p style="font-size:15px;line-height:1.6;color:#374151;margin:0 0 18px;">
    <strong style="color:#0d9488;">{{ $order->order_no }}</strong> numaralı yeni bir sipariş alındı.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;margin:0 0 18px;">
    <tr><td style="padding:4px 0;color:#6b7280;width:140px;">Müşteri</td><td style="padding:4px 0;">{{ $order->name }}</td></tr>
    <tr><td style="padding:4px 0;color:#6b7280;">Telefon</td><td style="padding:4px 0;">{{ $order->phone }}</td></tr>
    <tr><td style="padding:4px 0;color:#6b7280;">E-Posta</td><td style="padding:4px 0;">{{ $order->email }}</td></tr>
    <tr><td style="padding:4px 0;color:#6b7280;">Ödeme</td><td style="padding:4px 0;">{{ ucfirst($order->payment_method) }} ({{ $order->payment_status }})</td></tr>
    <tr><td style="padding:4px 0;color:#6b7280;">Adres</td><td style="padding:4px 0;">{{ $order->address }}{{ $order->district ? ', ' . $order->district : '' }}, {{ $order->city }}</td></tr>
    @if($order->note)
    <tr><td style="padding:4px 0;color:#6b7280;">Not</td><td style="padding:4px 0;">{{ $order->note }}</td></tr>
    @endif
</table>

@include('emails.partials.order-table')

<p style="margin:24px 0 0;">
    <a href="{{ route('admin.orders.show', $order) }}" style="display:inline-block;background:#0d9488;color:#ffffff;text-decoration:none;padding:11px 22px;border-radius:8px;font-size:14px;font-weight:bold;">Siparişi Görüntüle</a>
</p>
@endcomponent
