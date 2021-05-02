<x-app-layout>
    <div class="container mt-8 flex justify-center">
        <div class="card lg:w-1/2 w-4/5">
            <div class="card-body">
                <h4 class="text-xl mb-3 text-center">Registrar Usuario</h4>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    @isset($user)
                        <input type="hidden" name="id" value="{{$user->id}}" />
                    @endisset

                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="role">
                            Rol del Usuario
                        </label>
                        <select name="role" id="role" class="cursor-pointer shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                            <option value="">Escoga un Rol</option>
                            @foreach ($roles as $rl)
                                <option @if (isset($user)) {{$user->hasRole($rl->name) ? 'selected' :''}}  @endif value="{{$rl->id}}">{{$rl->name}}</option>
                            @endforeach
                            @php
                                unset($rl);
                            @endphp
                        </select>
                        @error('role')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
                            Nombre
                        </label>
                        <input id="name" type="text" name="name" value="{{!isset($user) ? old('name') : $user->name}}" required autofocus autocomplete="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                        @error('name')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
        
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <input id="email" type="email" name="email" value="{{!isset($user) ? old('email') : $user->email}}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                        @error('email')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
        
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                            Contraseña
                        </label>
                        <input id="password" type="password" name="password" autocomplete="new-password" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                        @error('password')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
        
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="password_confirmation">
                            Confirmar Contraseña
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                        @error('password_confirmation')
                            <span class="text-red-500">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="active">
                            Estado del Usuario
                        </label>
                        <select name="active" id="active" class="cursor-pointer shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                            <option @if (isset($user)) {{$user->active == '1' ? 'selected' :''}}  @endif  value="1">Activo</option>
                            <option @if (isset($user)) {{$user->active == '0' ? 'selected' :''}}  @endif  value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-end mb-4">
                        <button class="w-full btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

    </script>
</x-app-layout>
