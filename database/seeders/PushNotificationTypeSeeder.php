<?php

namespace Database\Seeders;

use App\Models\PushNotificationType;
use Illuminate\Database\Seeder;

class PushNotificationTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Sistema', 'slug' => PushNotificationType::SYSTEM],
            ['name' => 'Partido', 'slug' => PushNotificationType::MATCH],
        ];

        foreach ($types as $type) {
            PushNotificationType::updateOrCreate(['slug' => $type['slug']], $type);
        }
    }
}
