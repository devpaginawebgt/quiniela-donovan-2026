<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Limpia el cache de permisos antes de sembrar
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 1. Definir permisos
        $permissions = [
            'read   pools',
            'create pools',
            'update pools',

            'read   pools results',

            'read   quizzes',
            'create quizzes response',

            'read   calendar',
            'read   stadiums',
            'read   groups',
            'read   teams',
            'read   ranking',
            'read   prizes',

            // Permisos de admin
            'read admin',
            'read admin reports',
            'create admin notifications',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // 2. Crear rol admin y asignarle TODOS los permisos
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions([
            'read   pools',
            'read   pools results',
            'read   calendar',
            'read   stadiums',
            'read   groups',
            'read   teams',
            'read   ranking',
            'read   prizes',

            // Permisos de admin
            'read admin',
            'read admin reports',
            'create admin notifications',
        ]);

        // 3. Crear rol participante con permisos limitados
        $participante = Role::firstOrCreate(['name' => 'participant', 'guard_name' => 'web']);
        $participante->syncPermissions([
            'read   pools',
            'create pools',
            'update pools',

            'read   pools results',

            'read   quizzes',
            'create quizzes response',

            'read   calendar',
            'read   stadiums',
            'read   groups',
            'read   teams',
            'read   ranking',
            'read   prizes',
        ]);

        // 3. Crear rol trabajdor con permisos limitados
        $participante = Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'web']);
        $participante->syncPermissions([
            'read   pools',
            'create pools',
            'update pools',

            'read   pools results',

            'read   calendar',
            'read   stadiums',
            'read   groups',
            'read   teams',
            'read   ranking',
            'read   prizes',
        ]);
    }
}
