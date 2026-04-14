@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3>{{ $room->name }}</h3>
                <a href="{{ route('bookings.create', ['room_id' => $room->id]) }}" class="btn btn-success">
                    <i class="fas fa-calendar-plus"></i> Забронировать
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Информация о комнате</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Вместимость</th>
                            <td>{{ $room->capacity }} человек</td>
                        </tr>
                        <tr>
                            <th>Расположение</th>
                            <td>{{ $room->location }}</td>
                        </tr>
                        <tr>
                            <th>Оснащение</th>
                            <td>{{ $room->equipment ?? 'Не указано' }}</td>
                        </tr>
                        <tr>
                            <th>Статус</th>
                            <td>
                                @if($room->is_active)
                                    <span class="badge bg-success">Доступна</span>
                                @else
                                    <span class="badge bg-danger">Недоступна</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Описание</h5>
                    <p>{{ $room->description ?? 'Описание отсутствует' }}</p>
                </div>
            </div>
            
            <h5 class="mt-4">Бронирования этой комнаты</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Время</th>
                            <th>Мероприятие</th>
                            <th>Кто бронирует</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($room->bookings as $booking)
                        <tr>
                            <td>{{ $booking->date }}</td>
                            <td>{{ $booking->time_range }}</td>
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
        </div>
    </div>
</div>
@endsection