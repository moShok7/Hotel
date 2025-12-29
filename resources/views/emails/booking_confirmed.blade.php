<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Подтверждение бронирования</title>
</head>
<body>
    <h1>Бронирование подтверждено!</h1>
    <p>Номер бронирования: #{{ $booking->id }}</p>
    <p>Комната: {{ $booking->room->title }}</p>
    <p>Дата заезда: {{ \Carbon\Carbon::parse($booking->started_at)->format('d.m.Y') }}</p>
    <p>Дата выезда: {{ \Carbon\Carbon::parse($booking->finished_at)->format('d.m.Y') }}</p>
    <p>Количество ночей: {{ $booking->days }}</p>
    <p>Цена: {{ $booking->price }} руб.</p>
</body>
</html>
