<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<p>
    Dear Sir/Madam,<br/> <br/>
    On behalf of Grand Mosque Colombo ,we extend our heartfelt gratitude for your recent donation. Your generous contribution will go a long way in supporting our mosque's programs </p>

<table>
    <tr>
        <th style="text-align:left">Reference</th>
        <td>{{$data_export['order_number']}}</td>
    </tr>
    <tr>
        <th style="text-align:left">WEBXPAY Reference</th>
        <td>{{$data_export['webxpay_order_number']}}</td>
    </tr>
    <tr>
        <th style="text-align:left">Amount</th>
        <td>LKR {{$data_export['amount']}}</td>
    </tr>
    <tr>
        <th style="text-align:left" style="text-align:left">Payment Date</th>
        <td>{{$data_export['paid_date']}}</td>
    </tr>
</table>
<p>
    Regards,
</p>
<p>
    Grand Mosque Colombo
</p>
</body>
</html>