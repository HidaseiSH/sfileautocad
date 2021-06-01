<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
        <div class="lg:col-span-1">
            @if($alert)
                <div class="container">
                    <div class="block text-sm text-green-600 bg-green-200 border border-green-400 h-12 flex items-center p-4 rounded-sm relative" role="alert">
                        <strong class="mr-1">Bien!</strong> El archivo se subio con exito.
                        <button wire:click="close_alert" type="button" data-dismiss="alert" aria-label="Close">
                            <span class="absolute top-0 bottom-0 right-0 text-2xl px-3 py-1 hover:text-green-900" aria-hidden="true" >×</span>
                        </button>
                    </div>
                </div>
            @endif
            @if($alert_error)
                <div class="container">
                    <div class="block text-sm text-red-600 bg-red-200 border border-red-400 h-12 flex items-center p-4 rounded-sm relative" role="alert">
                        <strong class="mr-1">Error!</strong> Error al subir el archivo.'
                        <button wire:click="close_alert_error" type="button" data-dismiss="alert" aria-label="Close">
                            <span class="absolute top-0 bottom-0 right-0 text-2xl px-3 py-1 hover:text-red-900" aria-hidden="true" >×</span>
                        </button>
                    </div>
                </div>
            @endif
            @if($alert_error_type)
            <div class="container">
                <div class="block text-sm text-red-600 bg-red-200 border border-red-400 h-12 flex items-center p-4 rounded-sm relative" role="alert">
                    <strong class="mr-1">Error!</strong> La Actividad no soporta el tipo de archivo.'
                    <button wire:click="$set('alert_error_type',false)" type="button" data-dismiss="alert" aria-label="Close">
                        <span class="absolute top-0 bottom-0 right-0 text-2xl px-3 py-1 hover:text-red-900" aria-hidden="true" >×</span>
                    </button>
                </div>
            </div>
        @endif
        
            <div class="card">
                <div class="card-body">
                    <p class="mb-4">Subir Archivos</p>
                    
                    <div class="mb-4">
                        <form wire:submit.prevent="upload_file">
                            <div class="mb-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2">
                                    Actividad (Opcional)
                                </label>
                                <select wire:model="activity_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                                    <option value="">Seleccione Actividad</option>
                                    @foreach ($activities as $act)
                                        <option value="{{$act->id}}">{{$act->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2">
                                    Tipo de Archivo
                                </label>
                                <select wire:model="file_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                                    <option value="">Seleccione</option>
                                    <option value="Financiera">Financiera</option>
                                    <option value="Modelados">Modelados</option>
                                    <option value="Planos">Planos</option>
                                    <option value="Confidencial">Confidencial</option>
                                </select>
                                @error('description')
                                    <span class="text-red-500">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2">
                                    Breve Descripcion
                                </label>
                                <textarea wire:model="description" cols="30" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"></textarea>
                                @error('description')
                                    <span class="text-red-500">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input wire:model="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="file" type="file">
                                <div wire:loading wire:target="file">Uploading...</div>
                                @error('file')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>
                            <button @if($disabled) disabled @endif type="submit" class="w-full btn btn-primary">Subir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="flex flex-col pb-2">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <select wire:model="file_type_filter" class="shadow appearance-none w-1/4 border rounded py-2 px-3 text-grey-darker">
                            <option value="">Filtrar Por:</option>
                            <option value="Financiera">Financiera</option>
                            <option value="Modelados">Modelados</option>
                            <option value="Planos">Planos</option>
                            <option value="Confidencial">Confidencial</option>
                        </select>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th width="50%" scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            
                                        </th>
                                        <th width="50%" scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Descripcion
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
                                                @if ($fl->file_type != 'Confidencial')
                                                    <span class="cursor-pointer text-blue-500" wire:click="download({{$fl->id}},'{{$fl->url}}')">Descargar Archivo</span>
                                                @else
                                                    <span wire:click="set_url({{$fl->id}},'{{$fl->url}}')" class="cursor-pointer text-blue-500">Descargar Archivo</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$fl->my_description}}
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
                                        <button wire:click="close_alert" type="button" data-dismiss="alert" aria-label="Close">
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
