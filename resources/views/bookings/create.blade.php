@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Новое бронирование</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bookings.store') }}" id="bookingForm">
                        @csrf

                        <div class="mb-3">
                            <label for="room_id" class="form-label">Выберите комнату *</label>
                            <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                                <option value="">Выберите комнату</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" 
                                        data-capacity="{{ $room->capacity }}"
                                        {{ old('room_id', request('room_id')) == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }} (вместимость: {{ $room->capacity }} чел.) - {{ $room->location }}
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
                                   value="{{ old('event_name') }}" required>
                            @error('event_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea name="description" id="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="date" class="form-label">Дата *</label>
                                <input type="date" name="date" id="date" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="start_time" class="form-label">Время начала *</label>
                                <input type="time" name="start_time" id="start_time" 
                                       class="form-control @error('start_time') is-invalid @enderror" 
                                       value="{{ old('start_time', '10:00') }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="end_time" class="form-label">Время окончания *</label>
                                <input type="time" name="end_time" id="end_time" 
                                       class="form-control @error('end_time') is-invalid @enderror" 
                                       value="{{ old('end_time', '11:00') }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="participants_count" class="form-label">Количество участников</label>
                            <input type="number" name="participants_count" id="participants_count" 
                                   class="form-control @error('participants_count') is-invalid @enderror" 
                                   value="{{ old('participants_count') }}">
                            <small class="text-muted" id="capacityWarning"></small>
                            @error('participants_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="booked_by" class="form-label">Ваше имя *</label>
                                <input type="text" name="booked_by" id="booked_by" 
                                       class="form-control @error('booked_by') is-invalid @enderror" 
                                       value="{{ old('booked_by') }}" required>
                                @error('booked_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="text" name="phone" id="phone" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="additional_info" class="form-label">Дополнительная информация</label>
                            <textarea name="additional_info" id="additional_info" 
                                      class="form-control @error('additional_info') is-invalid @enderror" 
                                      rows="2">{{ old('additional_info') }}</textarea>
                            @error('additional_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info" id="availabilityCheck" style="display: none;"></div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Отмена</a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Забронировать</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Проверка вместимости
    document.getElementById('room_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var capacity = selectedOption.getAttribute('data-capacity');
        var participantsInput = document.getElementById('participants_count');
        var warningSpan = document.getElementById('capacityWarning');
        
        participantsInput.addEventListener('input', function() {
            var participants = parseInt(this.value);
            if (participants && capacity && participants > capacity) {
                warningSpan.innerHTML = '<span class="text-danger">Внимание! Количество участников превышает вместимость комнаты (' + capacity + ' чел.)</span>';
            } else {
                warningSpan.innerHTML = '';
            }
        });
    });

    // Проверка доступности комнаты
    const roomSelect = document.getElementById('room_id');
    const dateInput = document.getElementById('date');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const availabilityDiv = document.getElementById('availabilityCheck');

    function checkAvailability() {
        const roomId = roomSelect.value;
        const date = dateInput.value;
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;

        if (roomId && date && startTime && endTime) {
            fetch(`/rooms/${roomId}/availability?date=${date}&start_time=${startTime}&end_time=${endTime}`)
                .then(response => response.json())
                .then(data => {
                    if (data.available) {
                        availabilityDiv.style.display = 'block';
                        availabilityDiv.className = 'alert alert-success';
                        availabilityDiv.innerHTML = '✓ Комната доступна в выбранное время';
                        document.getElementById('submitBtn').disabled = false;
                    } else {
                        availabilityDiv.style.display = 'block';
                        availabilityDiv.className = 'alert alert-danger';
                        availabilityDiv.innerHTML = '✗ Комната уже забронирована на это время';
                        document.getElementById('submitBtn').disabled = true;
                    }
                });
        }
    }

    roomSelect.addEventListener('change', checkAvailability);
    dateInput.addEventListener('change', checkAvailability);
    startTimeInput.addEventListener('change', checkAvailability);
    endTimeInput.addEventListener('change', checkAvailability);
</script>
@endpush
@endsection