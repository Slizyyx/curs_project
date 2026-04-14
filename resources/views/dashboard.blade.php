@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Панель управления</h1>
    
    <!-- Статистика -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Активные комнаты</h5>
                    <h2 class="mb-0">{{ $totalRooms }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Бронирований сегодня</h5>
                    <h2 class="mb-0">{{ $activeBookings }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Ожидают подтверждения</h5>
                    <h2 class="mb-0">{{ $pendingBookings }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Всего комнат</h5>
                    <h2 class="mb-0">{{ $totalRooms }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Бронирования на сегодня -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Бронирования на сегодня</h5>
                </div>
                <div class="card-body">
                    @if($todayBookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Время</th>
                                        <th>Комната</th>
                                        <th>Мероприятие</th>
                                        <th>Кто бронирует</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todayBookings as $booking)
                                    <tr>
                                        <td>{{ $booking->time_range }}</td>
                                        <td>{{ $booking->room->name }}</td>
                                        <td>{{ $booking->event_name }}</td>
                                        <td>{{ $booking->booked_by }}</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status_badge }}">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Нет бронирований на сегодня</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Популярные комнаты -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Популярные комнаты</h5>
                </div>
                <div class="card-body">
                    @if($popularRooms->count() > 0)
                        <div class="list-group">
                            @foreach($popularRooms as $room)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $room->name }}</strong>
                                            <br>
                                            <small class="text-muted">Вместимость: {{ $room->capacity }} чел.</small>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">
                                            {{ $room->bookings_count }} бронирований
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Нет данных</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection