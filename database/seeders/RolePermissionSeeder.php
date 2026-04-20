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
            // Permisos del participante
            'participant.quiniela',
            'participant.trivias',

            // Permisos de admin
            'admin.acceder-panel',
            'admin.ver-reportes',
            'admin.enviar-notificaciones-push',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // 2. Crear rol admin y asignarle TODOS los permisos
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::all());

        // 3. Crear rol participante con permisos limitados
        $participante = Role::firstOrCreate(['name' => 'participant', 'guard_name' => 'web']);
        $participante->syncPermissions([
            'participant.quiniela',
            'participant.trivias',
        ]);
    }
}
