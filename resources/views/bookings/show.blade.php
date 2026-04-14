@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Детали бронирования #{{ $booking->id }}</h3>
                        <div>
                            @if($booking->status != 'cancelled')
                                <a href="{{ route('bookings.cancel', $booking) }}" class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Отменить бронирование?')">
                                    <i class="fas fa-times"></i> Отменить
                                </a>
                            @endif
                            <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-edit"></i> Редактировать
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Статус:</strong>
                            <span class="badge bg-{{ $booking->status_badge }} ms-2">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        <div class="col-md-6 text-end">
                            <strong>Создано:</strong> {{ $booking->created_at->format('d.m.Y H:i') }}
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Информация о мероприятии</h5>
                            <table class="table table-borderless">
                                <tr><th>Комната:</th><td>
                                    <a href="{{ route('rooms.show', $booking->room) }}">
                                        {{ $booking->room->name }}
                                    </a>
                                </td></tr>
                                <tr><th>Мероприятие:</th><td>{{ $booking->event_name }}</td></tr>
                                @if($booking->description)
                                <tr><th>Описание:</th><td>{{ $booking->description }}</td></tr>
                                @endif
                                <tr><th>Дата:</th><td>{{ \Carbon\Carbon::parse($booking->date)->format('d.m.Y') }}</td></tr>
                                <tr><th>Время:</th><td>{{ $booking->time_range }}</td></tr>
                                @if($booking->participants_count)
                                <tr><th>Участников:</th><td>{{ $booking->participants_count }}</td></tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Контактная информация</h5>
                            <table class="table table-borderless">
                                <tr><th>Кто бронирует:</th><td>{{ $booking->booked_by }}</td></tr>
                                @if($booking->email)
                                <tr><th>Email:</th><td>{{ $booking->email }}</td></tr>
                                @endif
                                @if($booking->phone)
                                <tr><th>Телефон:</th><td>{{ $booking->phone }}</td></tr>
                                @endif
                                @if($booking->additional_info)
                                <tr><th>Доп. информация:</th><td>{{ $booking->additional_info }}</td></tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                        ← Назад к списку
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection