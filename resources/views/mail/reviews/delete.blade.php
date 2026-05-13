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
                        {{ $title }}
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 18px; font-weight: bold; color: #000; padding-top: 10px; padding-bottom: 5px;">
                        Здравствуйте, {{ $name }}!
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 16px; font-weight: normal; color: #000; padding-bottom: 20px;">
                        {!! $messageBody !!}
                    </td>
                </tr>

                @if (!empty($moderatorNote))
                    <tr>
                        <td style="font-size: 16px; font-weight: bold; color: #000; padding-bottom: 10px;">
                            Комментарий модератора:
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; font-weight: normal; color: #000; padding-bottom: 20px;">
                            {!! nl2br(e($moderatorNote)) !!}
                        </td>
                    </tr>
                @endif

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
