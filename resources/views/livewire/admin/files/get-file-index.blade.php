<div>
    <div class="card mb-8">
        <div class="card-body">
            <div class="lg:w-1/3 w-full relative text-gray-600">
                <input wire:model="search" type="text" placeholder="Buscar" class="w-full bg-white h-10 px-5 pr-10 rounded-full text-sm focus:outline-none">
                <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
                  <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                    <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"/>
                  </svg>
                </button>
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
                                        <th width="50%" scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nombre del Propietario
                                        </th>
                                        <th width="50%" scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Correo del Propietario
                                        </th>
                                        <th width="50%" scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Descripcion
                                        </th>
                                        <th width="50%" scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            
                                        </th>
                                        <th width="50%" scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fecha de Creación
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($get_files as $fl)    
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$fl->name}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$fl->email}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $data = strpos($fl->description,'_');
                                                    $desc = substr($fl->description, $data + 1);
                                                @endphp
                                                {{$desc}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($fl->file_type != 'Confidencial')
                                                    <span class="cursor-pointer text-blue-500" wire:click="download({{$fl->id}},'{{$fl->url}}')">Descargar Archivo</span>
                                                @else
                                                    <span wire:click="set_url({{$fl->id}},'{{$fl->url}}')" class="cursor-pointer text-blue-500">Descargar Archivo</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$fl->created_at}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @php
                                        unset($fl)
                                    @endphp
                                </tbody>
                            </table>
                            {{$get_files->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="hidden modal-confirm fixed w-full inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
        <div class="border border-blue-500 shadow-lg modal-container bg-white w-full lg:w-5/12 md:max-w-11/12 mx-auto rounded-xl shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold text-gray-500">Confirme su Contraseñar</p>
                    <div class="modal-close cursor-pointer z-50" onclick="modalClose('modal-confirm');">
                        <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </div>
                </div>
                <!--Body-->
                <div class="my-5 flex justify-center">
                    <div class="card w-full">
                        <div class="card-body">
                            @if($alert_password)
                                <div class="container">
                                    <div class="text-sm text-red-600 bg-red-200 border border-red-400 h-12 flex items-center p-4 rounded-sm relative" role="alert">
                                        <strong class="mr-1">Error! La contraseña es incorrecta</strong> .
                                        <button wire:click="$set('alert_password',false)" type="button" data-dismiss="alert" aria-label="Close">
                                            <span class="absolute top-0 bottom-0 right-0 text-2xl px-3 py-1 hover:text-red-900" aria-hidden="true" >×</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2" for="pw">
                                    Ingresar Contraseña
                                </label>
                                <input wire:model="password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pt-2 space-x-14">
                    <button type="button" onclick="modalClose('modal-confirm');"
                        class="px-4 bg-gray-200 p-2 rounded text-black hover:bg-gray-300 font-semibold">Cancelar</button>
                    <button type="button" wire:click="password_confirm"
                        class="px-4 bg-blue-500 p-2 ml-3 rounded-lg text-white hover:bg-teal-400">Aceptar</button>
                </div>
                <!--Footer-->
            </div>
        </div>
    </div>
    @section('script')
        <script>
            Livewire.on('open_modal', postId => {
                openModal('modal-confirm')
            })
            Livewire.on('close_modal', (id,url) => {
                modalClose('modal-confirm')
                Livewire.emit('download',id,url)
            })
        </script>
    @endsection
</div>
