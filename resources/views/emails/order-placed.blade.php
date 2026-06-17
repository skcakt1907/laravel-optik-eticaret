@component('emails.layout', ['title' => 'Siparişiniz Alındı'])
<h1 style="font-size:22px;margin:0 0 6px;">Siparişiniz Alındı! 🎉</h1>
<p style="font-size:15px;line-height:1.6;color:#374151;margin:0 0 18px;">
    Merhaba <strong>{{ $order->name }}</strong>, siparişiniz başarıyla oluşturuldu.
    Sipariş numaranız: <strong style="color:#0d9488;">{{ $order->order_no }}</strong>
</p>

@if($order->payment_method === 'havale' && $order->payment_status !== 'paid')
<div style="background:#ecfdf5;border:1px solid #a7f3d0;border-radius:10px;padding:16px 18px;margin:0 0 18px;">
    <p style="margin:0 0 10px;font-size:15px;font-weight:bold;color:#065f46;">Havale / EFT Bilgileri</p>
    <p style="margin:0 0 10px;font-size:14px;line-height:1.6;color:#374151;">
        Aşağıdaki hesaba <strong>{{ money($order->total) }}</strong> tutarını gönderirken açıklamaya
        <strong>{{ $order->order_no }}</strong> yazmayı unutmayın.
    </p>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
        <tr><td style="padding:3px 0;color:#6b7280;width:120px;">Banka</td><td style="padding:3px 0;">{{ setting('havale_banka') }}</td></tr>
        <tr><td style="padding:3px 0;color:#6b7280;">Hesap Adı</td><td style="padding:3px 0;">{{ setting('havale_hesap_adi') }}</td></tr>
        <tr><td style="padding:3px 0;color:#6b7280;">IBAN</td><td style="padding:3px 0;"><strong>{{ setting('havale_iban') }}</strong></td></tr>
        <tr><td style="padding:3px 0;color:#6b7280;">Açıklama</td><td style="padding:3px 0;"><strong>{{ $order->order_no }}</strong></td></tr>
    </table>
</div>
@elseif($order->payment_method === 'kapida')
<div style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:14px 18px;margin:0 0 18px;font-size:14px;color:#92400e;">
    Ödemeyi teslimat sırasında <strong>kapıda</strong> yapacaksınız. Siparişiniz hazırlanıyor.
</div>
@elseif($order->payment_status === 'paid')
<div style="background:#ecfdf5;border:1px solid #a7f3d0;border-radius:10px;padding:14px 18px;margin:0 0 18px;font-size:14px;color:#065f46;">
    Ödemeniz başarıyla alındı. Siparişiniz hazırlanmaya başlandı.
</div>
@endif

<h3 style="font-size:16px;margin:18px 0 4px;">Sipariş Özeti</h3>
@include('emails.partials.order-table')

<h3 style="font-size:16px;margin:22px 0 4px;">Teslimat</h3>
<p style="font-size:14px;line-height:1.6;color:#374151;margin:0;">
    {{ $order->name }}<br>
    {{ $order->phone }}<br>
    {{ $order->address }}{{ $order->district ? ', ' . $order->district : '' }}, {{ $order->city }}
</p>

<p style="font-size:13px;color:#6b7280;margin:24px 0 0;line-height:1.6;">
    Siparişinizle ilgili sorularınız için bize {{ setting('telefon') }} numarasından veya
    {{ setting('eposta') }} adresinden ulaşabilirsiniz.
</p>
@endcomponent
