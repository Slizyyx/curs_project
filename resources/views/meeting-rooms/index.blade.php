<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Переговорные комнаты - Главная</title>
</head>
<body>
    <h1>Система бронирования переговорных комнат</h1>
    
    <hr>
    
    <h2>Доступные переговорные комнаты</h2>
    
    @if(isset($rooms) && count($rooms) > 0)
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название комнаты</th>
                    <th>Вместимость</th>
                    <th>Оборудование</th>
                    <th>Статус</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td><strong>{{ $room->name }}</strong></td>
                    <td>{{ $room->capacity }} чел.</td>
                    <td>{{ $room->equipment ?? 'Стандартное' }}</td>
                    <td>
                        @if($room->is_active)
                            <span style="color: green;">✓ Доступна</span>
                        @else
                            <span style="color: red;">✗ Недоступна</span>
                        @endif
                    </td>
                    <td>
                        <a href="/rooms/{{ $room->id }}">Подробнее</a> |
                        <a href="/booking/create?room_id={{ $room->id }}">Забронировать</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Нет доступных переговорных комнат</p>
    @endif
    
    <hr>
    
    <h2>Последние бронирования</h2>
    
    @if(isset($recentBookings) && count($recentBookings) > 0)
        <ul>
            @foreach($recentBookings as $booking)
            <li>
                <strong>{{ $booking->room_name }}</strong> - 
                {{ $booking->event_name }} | 
                Дата: {{ $booking->date }} | 
                Время: {{ $booking->start_time }} - {{ $booking->end_time }} |
                Статус: 
                @if($booking->status == 'confirmed')
                    <span style="color: green;">Подтверждено</span>
                @elseif($booking->status == 'pending')
                    <span style="color: orange;">Ожидает</span>
                @else
                    <span style="color: red;">Отменено</span>
                @endif
            </li>
            @endforeach
        </ul>
    @else
        <p>Нет активных бронирований</p>
    @endif
    
    <hr>
    
    <h2>Быстрые действия</h2>
    <ul>
        <li><a href="/rooms">Все комнаты</a></li>
        <li><a href="/booking/create">Новое бронирование</a></li>
        <li><a href="/my-bookings">Мои бронирования</a></li>
    </ul>
    
    <hr>
    
    <footer>
        <p>© 2026 Система бронирования переговорных комнат | Курсовой проект</p>
    </footer>
</body>
</html>