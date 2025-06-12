<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
</head>
<body style="margin:0; padding:0; background-color:#ffffff; font-family:Arial, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 40px 20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px;">
                <tr>
                    <td style="font-size: 28px; font-weight: bold; text-align: center; padding-bottom: 40px; color: #000;">
                        Заказ №{{ $order->id }} успешно оформлен!
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 16px; font-weight: normal; color: #000; padding-bottom: 20px;">
                        Спасибо за заказ, {{ $order->client_name }}!
                    </td>
                </tr>

                {{-- Детали заказа --}}
                <tr>
                    <td style="font-size: 18px; font-weight: bold; color: #000; padding-top: 10px; padding-bottom: 5px;">
                        Детали заказа:
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 16px; color: #000;">
                        Дата: {{ $order->created_at->format('d.m.Y H:i') }}<br>
                        Статус: {{ $order->status_label ?? ucfirst(str_replace('_', ' ', $order->status)) }}<br>
                        Доставка: {{ $order->delivery_method_label }}<br>
                        Оплата: {{ $order->payment_method_label }}<br>
                        @if ($order->client_social_type && $order->client_social_url)
                            Указанный способ связи: {{ ucfirst($order->client_social_type) }} —
                            <a href="{{ $order->client_social_url }}" style="color:#0000EE;">{{ $order->client_social_url }}</a>
                        @endif
                        <br>
                    </td>
                </tr>


                @if ($order->payment_method === 'manual')
                    <tr>
                        <td style="font-size: 14px; color: #000;">
                            * После оформления заказа по указанным вами данным для связи с вами свяжется наш администратор для оплаты доставки.<br>
                        </td>
                    </tr>
                @endif

                {{-- Состав заказа --}}
                <tr>
                    <td style="font-size: 18px; font-weight: bold; color: #000; padding-top: 20px; padding-bottom: 5px;">
                        Состав заказа:
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 16px; color: #000;">
                        @foreach ($order->products as $product)
                            • {{ $product->title }} × {{ $product->pivot->quantity }} — {{ $product->actual_price }} ₽<br>
                        @endforeach
                    </td>
                </tr>

                {{-- Итого --}}
                <tr>
                    <td style="font-size: 16px; color: #000; padding-top: 10px;">
                        <strong>Итого: {{ $order->total_price }} ₽</strong>
                    </td>
                </tr>

                {{-- Подпись --}}
                <tr>
                    <td style="font-size: 16px; color: #000; padding-top: 40px; text-align: center;">
                        С уважением,<br>
                        Команда {{ config('app.name') }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
