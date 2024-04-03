<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['name' => 'Super-Admin']);
        $superAdmin = User::factory()->create([
            'name' => 'superadmin',
            'email' => 'superadmin@admin.com',
            'password' => bcrypt("12345678"),
            'active' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        Permission::create(['name' => 'program users', 'description' => 'Programa - Usuario']);
        Permission::create(['name' => 'users create', 'description' => 'Crear Usuario']);
        Permission::create(['name' => 'module setting', 'description' => 'Modulo de Configuración']);
        Permission::create(['name' => 'users edit', 'description' => 'Editar Usuario']);
        Permission::create(['name' => 'users delete', 'description' => 'Eliminar Usuario']);
        Permission::create(['name' => 'program roles', 'description' => 'Programa - Roles y Permisos']);
        Permission::create(['name' => 'roles create', 'description' => 'Crear Roles y Permisos']);
        Permission::create(['name' => 'roles edit', 'description' => 'Editar Roles y Permisos']);
        Permission::create(['name' => 'roles delete', 'description' => 'Eliminar Roles y Permisos']);
    }
}
