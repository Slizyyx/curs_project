@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Переговорные комнаты</h1>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить комнату
        </a>
    </div>

    <div class="row">
        @foreach($rooms as $room)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="card-title">{{ $room->name }}</h5>
                        @if($room->is_active)
                            <span class="badge bg-success">Активна</span>
                        @else
                            <span class="badge bg-danger">Неактивна</span>
                        @endif
                    </div>
                    <p class="card-text">{{ Str::limit($room->description, 100) }}</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-users"></i> Вместимость: {{ $room->capacity }} чел.</li>
                        <li><i class="fas fa-location-dot"></i> Расположение: {{ $room->location }}</li>
                        <li><i class="fas fa-tools"></i> Оснащение: {{ $room->equipment ?? 'Не указано' }}</li>
                    </ul>
                    <div class="btn-group w-100">
                        <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Подробнее
                        </a>
                        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-edit"></i> Редактировать
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    {{ $rooms->links() }}
</div>
@endsection