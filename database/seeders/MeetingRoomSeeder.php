<?php

namespace Database\Seeders;

use App\Models\MeetingRoom;
use Illuminate\Database\Seeder;

class MeetingRoomSeeder extends Seeder
{
    public function run()
    {
        MeetingRoom::create([
            'name' => 'Конференц-зал "Альфа"',
            'capacity' => 20,
            'equipment' => 'Проектор, доска, Wi-Fi, кондиционер',
            'is_active' => true,
            'description' => 'Просторный зал для больших встреч'
        ]);
        
        MeetingRoom::create([
            'name' => 'Переговорная "Бета"',
            'capacity' => 8,
            'equipment' => 'Телевизор, маркерная доска',
            'is_active' => true,
            'description' => 'Для небольших команд'
        ]);
        
        MeetingRoom::create([
            'name' => 'Кабинет переговоров "Гамма"',
            'capacity' => 4,
            'equipment' => 'Ноутбук, телефонная связь',
            'is_active' => true,
            'description' => 'Для конфиденциальных переговоров'
        ]);
    }
}