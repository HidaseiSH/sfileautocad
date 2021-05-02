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

@can('Crear Rol')    
    <div class="container mt-5">
        <div class="flex justify-end">
            <a href="{{route('roles.create')}}" class="btn btn-success">Agregar Rol</a>
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
                                                    Id
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Nombre
                                                </th>
                                                <th width="20px"></th>
                                                <th width="20px"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            
                                            @foreach ($roles as $rl)    
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{$rl->id}}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{$rl->name}}
                                                    </td>
                                                    <td>
                                                        @can('Crear Rol')
                                                            <a href="{{route('roles.edit',$rl)}}" class="btn btn-primary">Editar</a>
                                                        @endcan
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        @can('Eliminar Rol')    
                                                            <form action="{{route('roles.destroy', $rl)}}" method="POST"
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
                                                unset($rl)
                                            @endphp
                                        </tbody>
                                    </table>
                                    {{$roles->links()}}
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
