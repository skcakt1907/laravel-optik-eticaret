<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin-top:8px;">
    <thead>
        <tr>
            <th align="left" style="padding:8px 0;border-bottom:2px solid #e5e7eb;font-size:13px;color:#6b7280;">Ürün</th>
            <th align="right" style="padding:8px 0;border-bottom:2px solid #e5e7eb;font-size:13px;color:#6b7280;">Tutar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $it)
        <tr>
            <td style="padding:10px 0;border-bottom:1px solid #f0f0f0;font-size:14px;">{{ $it->name }} <span style="color:#6b7280;">× {{ $it->qty }}</span></td>
            <td align="right" style="padding:10px 0;border-bottom:1px solid #f0f0f0;font-size:14px;">{{ money($it->total) }}</td>
        </tr>
        @endforeach
        <tr>
            <td style="padding:8px 0;font-size:14px;color:#6b7280;">Ara Toplam</td>
            <td align="right" style="padding:8px 0;font-size:14px;">{{ money($order->subtotal) }}</td>
        </tr>
        <tr>
            <td style="padding:4px 0;font-size:14px;color:#6b7280;">Kargo</td>
            <td align="right" style="padding:4px 0;font-size:14px;">{{ $order->shipping > 0 ? money($order->shipping) : 'Ücretsiz' }}</td>
        </tr>
        <tr>
            <td style="padding:10px 0;border-top:2px solid #e5e7eb;font-size:16px;font-weight:bold;">Toplam</td>
            <td align="right" style="padding:10px 0;border-top:2px solid #e5e7eb;font-size:16px;font-weight:bold;color:#0d9488;">{{ money($order->total) }}</td>
        </tr>
    </tbody>
</table>
