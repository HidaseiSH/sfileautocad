<div>
    <div class="card mb-8">
        <div class="card-body">
            <div>
                <input wire:model="date" id="date" type="date" class="bg-white h-10 px-5 pr-10 rounded-full text-sm focus:outline-none">
                <button onclick="clear_date()">Limpiar</button>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="flex flex-col pb-2">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acción
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nombre de Usuario
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Correo de Usuario
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fecha de Registro
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($user_audits as $audit)    
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @switch($audit->action)
                                                    @case('login')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            INICIO DE SESIÓN
                                                        </span>
                                                        @break
                                                    @case('logout')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            CIERRE DE SESIÓN
                                                        </span>
                                                        @break
                                                    @case('update_password')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            ACTUALIZACIÓN DE CONTRASEÑA
                                                        </span>
                                                        @break
                                                    @default
                                                        
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$audit->user->name}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$audit->user->email}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$audit->created_at}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @php
                                        unset($audit)
                                    @endphp
                                </tbody>
                            </table>
                            {{$user_audits->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            function clear_date(){
                document.getElementById('date').value = '';
                @this.set('date', '');
            }
        </script>
    @endsection
</div>
