<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(session('info'))
        <div class="container">
            <div class="block text-sm text-green-600 bg-green-200 border border-green-400 h-12 flex items-center p-4 rounded-sm relative" role="alert">
                <strong class="mr-1">En hora Buena!</strong> {{session('info')}}
                <button type="button" data-dismiss="alert" aria-label="Close" onclick="this.parentElement.remove();">
                    <span class="absolute top-0 bottom-0 right-0 text-2xl px-3 py-1 hover:text-green-900" aria-hidden="true" >×</span>
                </button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="container">
            <div class="block text-sm text-red-600 bg-red-200 border border-red-400 h-12 flex items-center p-4 rounded-sm relative" role="alert">
                <strong class="mr-1">Error!</strong> {{session('error')}}
                <button type="button" data-dismiss="alert" aria-label="Close" onclick="this.parentElement.remove();">
                    <span class="absolute top-0 bottom-0 right-0 text-2xl px-3 py-1 hover:text-red-900" aria-hidden="true" >×</span>
                </button>
            </div>
        </div>
    @endif

    @can('Crear Usuario')        
        <div class="container mt-5">
            <div class="flex justify-end">
                <a href="{{route('users.create')}}" class="btn btn-success">Agregar Usuario</a>
            </div>
        </div>
    @endcan
    <div class="container mt-5">
        <div class="card">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div class="flex flex-col pb-2">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Nombre
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Email
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Estado
                                                    </th>
                                                    <th width="20px"></th>
                                                    <th width="20px"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($users as $us)    
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            {{$us->name}}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            {{$us->email}}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            @if ($us->active == '1')
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    ACTIVO
                                                                </span>
                                                            @else
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                    INACTIVO
                                                                </span>
                                                            @endif
                                                          </td>
                                                        <td>
                                                            @can('Crear Usuario')
                                                                <a href="{{route('users.edit',$us)}}" class="btn btn-primary">Editar</a>
                                                            @endcan
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            @can('Eliminar Usuario')    
                                                                <form action="{{route('users.destroy', $us)}}" method="POST"
                                                                onsubmit="return is_delete()">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button class="btn btn-danger" type="submit">Eliminar</button>
                                                                </form>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @php
                                                    unset($us)
                                                @endphp
                                            </tbody>
                                        </table>
                                        {{$users->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>            
        </div>
    </div>

    @section('script')
    <script>

        function is_delete(){
            var x = confirm("¿Desea eliminar el usuario?");
            if (x){
                return true;
            }else{
                return false;
            }
        }
      </script>
    @endsection

</x-app-layout>
