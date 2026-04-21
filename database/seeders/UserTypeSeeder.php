<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_types = [
            ['name' => 'Dependiente', 'plural_name' => 'Dependientes'],
            ['name' => 'Doctor',      'plural_name' => 'Doctores'],
        ];

        foreach($user_types as $type) {
            UserType::create($type);
        }
    }
}
