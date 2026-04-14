@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Редактирование бронирования #{{ $booking->id }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bookings.update', $booking) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="room_id" class="form-label">Комната *</label>
                            <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }} (вместимость: {{ $room->capacity }} чел.)
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="event_name" class="form-label">Название мероприятия *</label>
                            <input type="text" name="event_name" id="event_name" 
                                   class="form-control @error('event_name') is-invalid @enderror" 
                                   value="{{ old('event_name', $booking->event_name) }}" required>
                            @error('event_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea name="description" id="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="3">{{ old('description', $booking->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="date" class="form-label">Дата *</label>
                                <input type="date" name="date" id="date" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       value="{{ old('date', $booking->date) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="start_time" class="form-label">Время начала *</label>
                                <input type="time" name="start_time" id="start_time" 
                                       class="form-control @error('start_time') is-invalid @enderror" 
                                       value="{{ old('start_time', substr($booking->start_time, 0, 5)) }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="end_time" class="form-label">Время окончания *</label>
                                <input type="time" name="end_time" id="end_time" 
                                       class="form-control @error('end_time') is-invalid @enderror" 
                                       value="{{ old('end_time', substr($booking->end_time, 0, 5)) }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="participants_count" class="form-label">Количество участников</label>
                            <input type="number" name="participants_count" id="participants_count" 
                                   class="form-control @error('participants_count') is-invalid @enderror" 
                                   value="{{ old('participants_count', $booking->participants_count) }}">
                            @error('participants_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Статус</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Ожидает</option>
                                <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Подтверждено</option>
                                <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Отменено</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="booked_by" class="form-label">Ваше имя *</label>
                                <input type="text" name="booked_by" id="booked_by" 
                                       class="form-control @error('booked_by') is-invalid @enderror" 
                                       value="{{ old('booked_by', $booking->booked_by) }}" required>
                                @error('booked_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $booking->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="text" name="phone" id="phone" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $booking->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="additional_info" class="form-label">Дополнительная информация</label>
                            <textarea name="additional_info" id="additional_info" 
                                      class="form-control @error('additional_info') is-invalid @enderror" 
                                      rows="2">{{ old('additional_info', $booking->additional_info) }}</textarea>
                            @error('additional_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Отмена</a>
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection