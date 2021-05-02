<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'Administrador']);
        $role->syncPermissions([
            'Ver Usuarios',
            'Crear Usuario',
            'Eliminar Usuario',
            'Ver Roles',
            'Crear Rol',
            'Eliminar Rol',
            'Ver Archivos',
            'Ver Archivos Recibidos',
            'Ver Auditoria'
            ]);

        $role = Role::create(['name' => 'Usuario']);
        $role->syncPermissions(['Ver Archivos','Ver Archivos Recibidos']);
    }
}
