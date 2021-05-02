<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Ver Roles')->only('index');
        $this->middleware('can:Crear Rol')->only('create','store','edit');
        $this->middleware('can:Eliminar Rol')->only('destroy');
      //  $this->middleware('can:Editar usuarios')->only('edit', 'update');
    }

    public function index(){
        $roles = Role::latest('id')->paginate('10');
        return view('admin.roles.index', compact('roles'));
    }

    public function create(){
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);
        $type = "info";
        $msg = "El Rol se registró con exito.";
        $role = !isset($request->id) ? new Role() : Role::find($request->id);

        if (!isset($request->id)){
            $role->name= $request->name;
            if(!$role->save()){
                $type = "error";
                $msg = "Error al registrar el error.";
            }else{
                $role->refresh();
                $role->permissions()->attach($request->permissions);
            }
        }else{
            $role->permissions()->sync($request->permissions);
        }
        
        return redirect()->route('roles.index')->with($type,$msg);
    }

    public function edit(Role $role){
        $permissions = Permission::all();
        return view('admin.roles.create', compact('role','permissions'));
    }

    public function destroy(Role $role){
        $role->delete();
        return redirect()->route('roles.index')->with('info','El rol se eliminó con exito.');
    }
}
