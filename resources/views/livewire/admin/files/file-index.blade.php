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
                        <strong class="mr-1">Bien!</strong> Error al subir el archivo.'
                        <button wire:click="close_alert_error" type="button" data-dismiss="alert" aria-label="Close">
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
                                                <span class="cursor-pointer text-blue-500" wire:click="download({{$fl->id}},'{{$fl->url}}')">Descargar Archivo</span>
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
</div>
