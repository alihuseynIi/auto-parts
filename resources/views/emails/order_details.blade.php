<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Sifariş Alındı</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            color: black;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #218838;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🚀 Yeni Sifariş Alındı (#{{ $order->id }})</h2>
    <b>Salam Admin,</b>
    <p>Yeni bir sifariş alındı! Detalları aşağıdadır:</p>

    <table>
        <tr>
            <th>Sifariş No</th>
            <td>#{{ $order->id }}</td>
        </tr>
        <tr>
            <th>İstifadəçi</th>
            <td>{{ $order->user ? $order->user->name : 'Anonim' }}</td>
        </tr>
        <tr>
            <th>Ünvan</th>
            <td>{{ $order->address ?? 'Məlumat yoxdur' }}</td>
        </tr>
        <tr>
            <th>Çatdırılma Saatı</th>
            <td>{{ $order->date }}</td>
        </tr>
        <tr>
            <th>Toplam Qiymət</th>
            <td>{{ number_format($order->total_price, 2) }} AZN</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>Gözləmədə</td>
        </tr>
    </table>

    <a href="{{ url('nova/resources/orders/' . $order->id) }}" class="btn">Sifarişi Gör</a>

    <p class="footer">© {{ date('Y') }} {{ config('app.name') }}. Bütün hüquqlar qorunur.</p>
</div>

</body>
</html>
