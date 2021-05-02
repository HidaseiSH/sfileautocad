<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mt-8">
        <div class="card">
            <div class="card-body">        
                <form action="{{route('roles.store')}}" method="POST">
                    @csrf
                    @isset($role)
                        <input type="hidden" name="id" value="{{$role->id}}" />
                    @endisset
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <div class="lg:col-span-1">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <label class="block text-grey-darker text-sm font-bold mb-2" for="role">
                                            Nombre del Rol
                                        </label>
                                        <input value="{{isset($role) ? $role->name :''}}" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="role" type="text" placeholder="Rol">
                                        @error('name')
                                            <span class="text-red-500">{{$message}}</span>
                                        @enderror
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-2">
                            <div class="card pb-6">
                                <div class="card-body">
                                    <p class="text-2xl">Permisos</p>
                                    @error('permissions')
                                        <span class="text-red-500">{{$message}}</span>
                                    @enderror
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach ($permissions as $per)
                                            <div>
                                                <label class="inline-flex items-center mt-3" for="per{{$per->id}}">
                                                    <input @if (isset($role)) @if ($role->permissions->contains($per)) checked @endif @endif id="per{{$per->id}}" name="permissions[]" value="{{$per->id}}" type="checkbox" class="rounded-md h-5 w-5 text-gray-600 cursor-pointer">
                                                    <span class="cursor-pointer ml-2 text-gray-700">{{$per->name}}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                        @php
                                            unset($per);
                                        @endphp
                                    </div>
                                </div>
                                <div class="flex justify-center">
                                    <button type="submit" class="btn btn-primary sm:w-full lg:w-2/6">Registrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('script')
    <script>

        function is_delete(){
            var x = confirm("¿Desea eliminar el rol?");
            if (x){
                return true;
            }else{
                return false;
            }
        }
      </script>
    @endsection

</x-app-layout>
