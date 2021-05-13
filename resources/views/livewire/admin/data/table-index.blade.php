<div class="container">
    <div>
        <select wire:model="type" class="border-gray-300 bg-white border rounded h-10 px-5 pr-16 text-sm focus:border-transparent">
            <option value="download">Descarga de Archivo</option>
            <option value="upload">Subida de Archivo</option>       
        </select>
        <select wire:model="year" class="border-gray-300 bg-white border rounded h-10 px-5 pr-16 text-sm focus:border-transparent">
            <option value="">Seleccione un año</option>
            @foreach ($years as $y)
                <option value="{{$y->year}}">{{$y->year}}</option>
            @endforeach
            @php
                unset($y)
            @endphp
        </select>
        @if ($year)
            <select wire:model="month" class="border-gray-300 bg-white border rounded h-10 px-5 pr-16 text-sm focus:border-transparent">
                <option value="">Seleccione un mes</option>
                @foreach ($this->months as $m)
                    <option value="{{$m->month}}">{{$this->own_months($m->month)}}</option>
                @endforeach
                @php
                    unset($m)
                @endphp
            </select>                    
        @endif
        {{$this->days_month}}
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
                                            Archivos
                                        </th>
                                        @for ($i = 0; $i < $this->days_month; $i++)
                                            <th>{{$i + 1}}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($this->days_data as $item)
                                        <tr>
                                            <td>
                                                {{$item['name']}}
                                            </td>
                                            @for ($i = 1; $i <= $this->days_month; $i++)
                                                <td>
                                                    {{$this->filter_data($i, $item['data'])}}
                                                </td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
