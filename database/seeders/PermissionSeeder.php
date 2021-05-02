<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name'=>'Ver Usuarios']);
        Permission::create(['name'=>'Crear Usuario']);
        Permission::create(['name'=>'Eliminar Usuario']);
        Permission::create(['name'=>'Ver Roles']);
        Permission::create(['name'=>'Crear Rol']);
        Permission::create(['name'=>'Eliminar Rol']);
        Permission::create(['name'=>'Ver Archivos']);
        Permission::create(['name'=>'Ver Archivos Recibidos']);
        Permission::create(['name'=>'Ver Auditoria']);
    }
}
