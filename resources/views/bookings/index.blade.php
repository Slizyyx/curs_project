@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Управление бронированиями</h1>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Новое бронирование
        </a>
    </div>

    <!-- Фильтры -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('bookings.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Статус</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Все</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Ожидает</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Подтверждено</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Отменено</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Дата от</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Дата до</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block w-100">Применить фильтр</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Список бронирований -->
    <div class="card">
        <div class="card-body">
            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Комната</th>
                                <th>Мероприятие</th>
                                <th>Дата</th>
                                <th>Время</th>
                                <th>Кто бронирует</th>
                                <th>Участников</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>
                                    <a href="{{ route('rooms.show', $booking->room) }}">
                                        {{ $booking->room->name }}
                                    </a>
                                </td>
                                <td>{{ $booking->event_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->date)->format('d.m.Y') }}</td>
                                <td>{{ $booking->time_range }}</td>
                                <td>
                                    {{ $booking->booked_by }}
                                    <br>
                                    <small class="text-muted">{{ $booking->email }}</small>
                                </td>
                                <td>{{ $booking->participants_count ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status_badge }}">
                                        @if($booking->status == 'pending')
                                            Ожидает
                                        @elseif($booking->status == 'confirmed')
                                            Подтверждено
                                        @else
                                            Отменено
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($booking->status != 'cancelled')
                                            <a href="{{ route('bookings.cancel', $booking) }}" class="btn btn-outline-danger" 
                                               onclick="return confirm('Вы уверены, что хотите отменить это бронирование?')">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $bookings->links() }}
                </div>
            @else
                <p class="text-muted text-center">Нет бронирований</p>
            @endif
        </div>
    </div>
</div>
@endsection