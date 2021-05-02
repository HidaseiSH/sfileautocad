<?php

namespace App\Http\Controllers;

use App\Events\UserAuditType;
use App\Models\User;
use App\Models\UserAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Ver Usuarios')->only('index');
        $this->middleware('can:Crear Usuario')->only('create','store','edit');
        $this->middleware('can:Eliminar Usuario')->only('destroy');
      //  $this->middleware('can:Editar usuarios')->only('edit', 'update');
    }

    public function index(){
        $users = User::latest('id')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create(){
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }


    public function store(Request $request){
        $msg = '';
        $type = 'info';
        $user = !isset($request->id) ? new User() : User::find($request->id);
        $validate = !isset($request->id) ? 'required' : 'nullable';
        $request->validate([
            'role' => 'required',
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => $validate.'|confirmed|min:3',
            'password_confirmation' => $validate.'|min:3',
        ]);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->active = $request->active;
        if (!isset($request->id)) {
            $msg = 'El usuario se registró con exito.';
            $user->assignRole($request->role);
            $user->password=bcrypt($request->password);
        }else{
            $msg = 'El usuario se editó con exito.';
            $user->syncRoles([$request->role]);
            if($request->password != null){
                $user->password=bcrypt($request->password);
            }
        }

        if (!$user->save()) {
            $msg = !isset($request->id) ? 'Error al registrar el usuario.' : 'Error al editar el usuario.';
            $type = 'error';
        }
        return redirect()->route('users.index')->with($type,$msg);
    }

    public function edit(User $user){
        $roles = Role::all();
        return view('admin.users.create', compact('user', 'roles'));
    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->route('users.index')->with('info','El usuario se eliminó con exito.');
    }

    public function change_password(Request $request){
        $user = User::find(Auth::user()->id);
        $validator = Validator::make($request->all(),[
            'pwc' => ['required','min:3',function($attribute, $value, $fail) use ($user){
                if (!Hash::check($value, $user->password)) {
                    return $fail(__('La contraseña actual es incorrecta.'));
                }
            }],
            'pw' => 'required|confirmed|min:3',
            'pw_confirmation' => 'required|min:3',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('info_password','asd');
        }
        $type = "password_success";
        $msg = 'La constraseña se modifico con exito.';
        $user->password = bcrypt($request->pw);
        if (!$user->save()) {
            $type = "password_error";
            $msg = "Error al modificar la constraseña.";
        }else{
            UserAuditType::dispatch(Auth::user()->id,UserAudit::ACTION_UPDATE_PASSWORD);
        }
        return redirect()->back()->with($type,$msg);
    }
}
